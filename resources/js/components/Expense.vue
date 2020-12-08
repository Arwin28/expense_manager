
<template>
    <div class="container">
        <div class="row mt-5" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Expense</h3>

                        <div class="card-tools">

                            <button class="btn btn-success" @click="newModal()">
                                add new
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <div class="row mt-2">
                            <label style="margin-left: 4%;margin-top: 1%; margin-right: 1%">Filter by name</label>
                            <input class="form-control col-md-4"
                                   v-model="filters.name.value"
                            />
                        </div>
                        <v-table class="table table-hover text-nowrap" :data="expenses"
                                 :filters="filters"
                                 :hideSortIcons="true"
                                 :currentPage.sync="currentPage"
                                 :pageSize="pageSize"
                                 @totalPagesChanged="totalPages = numb ">
                            <thead slot="head">
                            <v-th  sortKey="category">Category</v-th>
                            <v-th  sortKey="name">Description</v-th>
                            <v-th  sortKey="amount">Amount</v-th>
                            <v-th  sortKey="entry_at">Entry Date</v-th>
                            <v-th  sortKey="created_at">Created Date</v-th>
                            <th>Modify</th>
                            </thead>
                            <tbody slot="body" slot-scope="{displayData}">
                            <tr v-for="row in displayData" :key="row.guid">
                                <td>{{ row.category }}</td>
                                <td>{{ row.description }}</td>
                                <td>{{ row.amount }}</td>                    
                                <td>{{ row.entry_at }}</td>
                                <td>{{ row.created_at }}</td>
                                <td>
                                    <a href="#" @click="editModal(row)">
                                        <i class="fas fa-user-edit teal "></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteUser(row.id)">
                                        <i class="fas fa-trash red "></i>
                                    </a>
                                </td>

                            </tr>
                            </tbody>
                        </v-table>
                        <smart-pagination
                            :currentPage.sync="currentPage"
                            :totalPages="totalPages"
                        />
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

   
        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Add new </h5>
                        <h5 v-show="editMode" class="modal-title" id="addNewLabel2">Update Expense </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <template>
                            <label>Select Category:</label>
                            <select  class='form-control' name="category_id" v-model="form.category_id" :class="{ 'is-invalid': form.errors.has('category') }">
                       
                              <option v-for='data in categories' :value='data.id'>{{ data.name }}</option>
                            </select>
                        <div class="form-group">
                                <label>Amount</label>
                                <input v-model="form.amount" type="text" name="amount"
                                       placeholder="Enter amount "
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('amount') }">
                                <has-error :form="form" field="amount"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.description" type="text" name="description"
                                       placeholder="Enter description "
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                <has-error :form="form" field="description"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" v-model="form.entry_at"  name="entry_at"
                                       placeholder="Enter Entry Date "
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('entry_at') }">
                                <has-error :form="form" field="entry_at"></has-error>
                            </div>
                        </template>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
                            <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>  
                       
<script>  
    export default {
        mounted() {
           Fire.$on('searching', () => {
                let text = this.$parent.search;
                axios.get('api/findUser?q=' + text)
                    .then((data) => {
                        this.expenses = data
                    })
                    .chatch((err) => {
                        console.log(err)
                    })
            });
            this.loadUsers();
            Fire.$on('AfterCreate', () => {
                this.loadUsers();
            });
            this.intervalFetchData();
        
        },
        data(){
            return {
                country: 0,
                categories: [],

                editMode: false,
                expenses: {},
                pageSize: 5,
                currentPage: 1,
                totalPages: 0,

                // Create a new form instance
                form: new Form({
                    id: '',
                    amount: '',
                    category_id: '',
                    description: '',
                    entry_at: '',
                }),
                filters: {
                    name: {value: '', keys: ['name']},
                }
            }
        },
        methods: {
            dateSort(a, b) {
                let date1 = new Date(a.created_at).getTime();
                let date2 = new Date(b.created_at).getTime();
                return date1 - date2;
            },
            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            editModal(user) {
                this.editMode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            updateUser() {
                this.$Progress.start();
                this.form.put('api/expenses/' + this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'User updated  successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(() => {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong!'
                        });
                        this.$Progress.fail();
                    })
            },
            deleteUser(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('api/expenses/' + id)
                            .then((res) => {

                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                Fire.$emit('AfterCreate');
                            })
                            .catch(() => {
                                Swal.fire(
                                    'Failed!',
                                    'Something went wrong!',
                                    'warning'
                                )
                            })
                    }
                })
            },
            loadUsers() {
                if (this.$gate.isAdminOrAuthor) {

                    axios.get("api/expenses").then(({data}) => {
                        this.expenses = data;
                        this.totalPages = Math.round((this.expenses.length)/(this.pageSize))+1 ;
                    });
                }
            },
            createUser() {
                this.$Progress.start()
                this.form.post('api/expenses')
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Expense created successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong!'
                        });
                        this.$Progress.fail()
                    })
            },
            intervalFetchData: function () {
                setInterval(() => {
                    this.loadUsers();

                }, 30000);
            },

            getCategories(){
              axios.get('api/get_data_dropdown')
              .then(function (response) {
                 this.categories = response.data;
              }.bind(this));

            }
        },
  
        created: function(){
            this.getCategories()
        }
    }
</script>

