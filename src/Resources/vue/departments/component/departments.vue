<template>
  <div class="row justify-content-md-center">
    <div class="card col-sm-12">
      <div class="card-body text-left">
        <div class="form-row row">
          <div class="col-md-2 mb-2"> 
            <button class="btn btn-primary" data-bs-toggle="modal" data-toggle="modal" data-bs-target="#addNewDep" data-target="#addNewDep"><i class="fa fa-plus"></i> دپارتمان جدید</button>
          </div>
          <div class="col-md-4 mb-2">   
              <input type="text" class="form-control" id="searchQuery" v-model="searchQuery" placeholder="جستجو " autocomplete="off">  
          </div>
          <div class="col-md-2 mb-2">
            <select class="form-control" id="itemsPerPage" v-model="itemsPerPage">
              <option value="5">5 مورد در صفحه</option>
              <option value="10">10 مورد در صفحه</option>
              <option value="20">20 مورد در صفحه</option>
              <option value="30">30 مورد در صفحه</option>
              <option value="40">40 مورد در صفحه</option>
              <option value="50">50 مورد در صفحه</option>
              <option value="100">100 مورد در صفحه</option>
            </select>
          </div>
          <div class="col-md-2 mb-2">
              <button class="btn btn-info btn-block" @click="getDeps()"><i class="fa fa-search"></i></button>
          </div>          
        </div>          
      </div>            
    </div>
  </div>
  <div class="row justify-content-md-center mt-3">
    <div class="card col-sm-12">
      <div class="card-body text-left">
          <table class="table table-hover table-stripe">
              <tr>
                <th>نام</th>
                <th>منو</th>
              </tr>
              <tr v-for="item in deps">
                <td>{{ item.name }}</td>
                <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu" style="">
                        <a class="dropdown-item" href="javascript:void(0);" @click="editId=item.id;getEmployeeDeps()" data-bs-toggle="modal" data-toggle="modal" data-bs-target="#employeeDep" data-target="#employeeDep"><i class="fa fa-users me-1"></i>  کارکنان</a>
                        <a class="dropdown-item" href="javascript:void(0);" @click="editId=item.id" data-bs-toggle="modal" data-toggle="modal" data-bs-target="#editNewDep" data-target="#editNewDep"><i class="bx bx-edit-alt me-1"></i> ویرایش</a>
                        <a class="dropdown-item" href="javascript:void(0);"  @click="deleteDep(item.id)"><i class="bx bx-trash me-1"></i> حذف</a>
                      </div>
                    </div>
                  </td>                
              </tr>
          </table>
          <div class="modal fade" id="employeeDep" tabindex="-1" aria-labelledby="employeeDepLabel" style="display: none;" aria-hidden="false">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="employeeDepLabel">کارکنان</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-10 col-md-10">
                      <div class="form-group">
                          <input type="text" class="form-control" id="employee_username" v-model="employee_username" placeholder="نام کاربری را وارد کنید">
                      </div>
                    </div>
                    <div class="col-sm-10 col-md-2">
                      <button type="button" class="btn btn-success btn-block btn-sm" @click="saveNewEmployeeDep()">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>نام کاربری</th>
                          <th>نام</th>
                          <th>نام خانوادگی</th>
                          <th>سمت</th>
                          <th>عملیات</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in DepartmentUser">
                          <td></td>
                          <td>{{ item.user.username }}</td>
                          <td>{{ item.user.name }}</td>
                          <td>{{ item.user.last_name }}</td>
                          <td>{{ translateText(item.job_position)}}</td>
                          <td>
                            <div class="dropdown">
                              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="javascript:void(0);"  @click="deleteEmployeeDep(item.id)"><i class="bx bx-trash me-1"></i> حذف</a>
                                <a class="dropdown-item" href="javascript:void(0);"  @click="setAdminDep(item.id)"><i class="bx bx-trash me-1"></i> ثبت به عنوان مدیر</a>
                              </div>
                            </div>
                          </td> 
                        </tr>
                      </tbody>
                    </table>                   
                  </div>
                </div>
              </div>  
            </div>
          </div>   
          <div class="modal fade" id="addNewDep" tabindex="-1" aria-labelledby="addNewDepLabel" style="display: none;" aria-hidden="false">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addNewDepLabel">ایجاد دیپارتمان</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-12 col-md-12">
                      <div class="form-group">
                          <label for="new_dep_name">عنوان دپارتمان</label>
                          <input type="text" class="form-control" id="new_dep_name" v-model="new_dep_name" placeholder="عنوان دپارتمان را وارد کنید">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                      <br>
                      <button type="button" class="btn btn-danger btn-block" data-bs-dismiss="modal" data-dismiss="modal">
                        <i class="fa fa-close menu-icon"></i> لغو
                      </button>
                    </div>  
                    <div class="col-sm-12 col-md-2">
                      <br>
                      <button type="button" class="btn btn-success btn-block" @click="saveNewDep()">
                        <i class="fa fa-save menu-icon"></i> ایجاد
                      </button>
                    </div>                      
                  </div>
                </div>
              </div>  
            </div>
          </div> 
          <div class="modal fade" id="editNewDep" tabindex="-1" aria-labelledby="editNewDepLabel" style="display: none;" aria-hidden="false">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editNewDepLabel">ویرایش دیپارتمان</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-12 col-md-12">
                      <div class="form-group">
                          <label for="new_dep_name">عنوان دپارتمان</label>
                          <input type="text" class="form-control" id="new_dep_name" v-model="new_dep_name" placeholder="عنوان دپارتمان را وارد کنید">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                      <br>
                      <button type="button" class="btn btn-danger btn-block" data-bs-dismiss="modal" data-dismiss="modal">
                        <i class="fa fa-close menu-icon"></i> لغو
                      </button>
                    </div>  
                    <div class="col-sm-12 col-md-2">
                      <br>
                      <button type="button" class="btn btn-success btn-block" @click="editDep()">
                        <i class="fa fa-save menu-icon"></i> ویرایش
                      </button>
                    </div>                      
                  </div>
                </div>
              </div>  
            </div>
          </div>           
      </div>
    </div>     
  </div>
 
</template>

<style>
.editable {
  cursor: pointer;
}
</style>

<script>
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      date: '',
      pagination: {
          total: 0,
          per_page: 2,
          from: 1,
          to: 0,
          current_page: 1,
          last_page: 1
      },
      offset:4,
      itemsPerPage:20,   
      searchQuery:'', 

      dep_name:'',
      pid:'',
      deps:[],
      editId:'',

      employee_username:'',
      DepartmentUser:[],
    };
  },
  components: {
  },  
  mounted() {
    this.getDeps();
  },  
  methods: {
    setAdminDep(id)
    {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'setAdminDep';
        axios.request({
          method: 'PUT', 
          url: this.getAppUrl() + 'api/admin/departments',
          headers: {'Authorization': `Bearer ${token}`},
          data: { action, id }
        }).then(response => {
          this.getEmployeeDeps();
          Swal.fire(
            'ویرایش شد!',
            'مدیر دپارتمان با موفقیت ثبت شد',
            'success'
          );          
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
        this.checkError(error);
      });
    },     
    editDep()
    {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'editDep';
        const dep_name = this.new_dep_name;
        const dep_id = this.editId;
        axios.request({
          method: 'PUT', 
          url: this.getAppUrl() + 'api/admin/departments',
          headers: {'Authorization': `Bearer ${token}`},
          data: { action, dep_name, dep_id }
        }).then(response => {
          this.getDeps();
          Swal.fire(
            'ویرایش شد!',
            'دپارتمان با موفقیت ویرایش شد.',
            'success'
          );          
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
        this.checkError(error);
      });
    },    
    submitDeleteDep(id){
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'deleteDep';
        const dep_id = id;
        axios.request({
          method: 'delete',
          url: this.getAppUrl() + 'api/admin/departments',
          headers: {'Authorization': `Bearer ${token}`},
          data: { 'action': action, 'dep_id':dep_id}
        }).then(response => {
          this.searchQuery = '';
          this.getDeps();
          Swal.fire(
            'حذف شد!',
            'دپارتمان با موفقیت حذف شد.',
            'success'
          );           
        }).catch(error => {
          this.checkError(error);
        });        
      }).catch(error => {
          this.checkError(error);
      });       
    },
    deleteDep(index) {
      Swal.fire({
        title: 'آیا اطمینان دارید؟',
        text: "تمام اطلاعات این دپارتمان به صورت کامل حذف خواهد شد!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'بله، حذف کن!',
        cancelButtonText: 'لغو'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submitDeleteDep(index);
        }
      });
    },    
    getDeps()
    {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        axios.request({
          method: 'GET',
          url: this.getAppUrl() + 'api/admin/departments?action=getDeps',
          headers: {'Authorization': `Bearer ${token}`}
        }).then(response => {
          this.deps = response.data.deps;
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
          this.checkError(error);
      });      
    },    
    saveNewDep()
    {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'saveNewDep';
        const pid = this.pid;
        const dep_name = this.new_dep_name;
        axios.request({
          method: 'POST', // از PUT برای ویرایش استفاده می‌کنیم
          url: this.getAppUrl() + 'api/admin/departments',
          headers: {'Authorization': `Bearer ${token}`},
          data: { action, pid, dep_name }
        }).then(response => {
          this.getDeps()
          Swal.fire(
            'ثبت شد!',
            'دپارتمان با موفقیت ثبت شد',
            'success'
          );
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
        this.checkError(error);
      });
    },  
    getEmployeeDeps()
    {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const dep_id = this.editId;
        axios.request({
          method: 'GET',
          url: this.getAppUrl() + 'api/admin/departments?action=getEmployeeDeps&dep_id=' + dep_id,
          headers: {'Authorization': `Bearer ${token}`}
        }).then(response => {
          this.DepartmentUser = response.data.DepartmentUser;
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
          this.checkError(error);
      });      
    },     
    saveNewEmployeeDep()
    {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'saveNewEmployeeDep';
        const dep_id = this.editId;
        const employee_username = this.employee_username;
        axios.request({
          method: 'POST', // از PUT برای ویرایش استفاده می‌کنیم
          url: this.getAppUrl() + 'api/admin/departments',
          headers: {'Authorization': `Bearer ${token}`},
          data: { action, dep_id, employee_username }
        }).then(response => {
          this.getEmployeeDeps()
          this.employee_username = ''
          Swal.fire(
            'ثبت شد!',
            'کاربر با موفقیت به دپارتمان اضافه شد',
            'success'
          );
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
        this.checkError(error);
      });
    },     
    deleteEmployeeDep(index) {
      Swal.fire({
        title: 'آیا اطمینان دارید؟',
        text: "این کاربر از دپارتمان حذف شود؟!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'بله، حذف کن!',
        cancelButtonText: 'لغو'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submitDeleteEmployeeDep(index);
        }
      });
    },
    submitDeleteEmployeeDep(id){
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'deleteEmployeeDep';
        const dep_user_id = id;
        axios.request({
          method: 'delete',
          url: this.getAppUrl() + 'api/admin/departments',
          headers: {'Authorization': `Bearer ${token}`},
          data: { 'action': action, 'dep_user_id':dep_user_id}
        }).then(response => {
          this.employee_username = ''
          this.getEmployeeDeps()
          Swal.fire(
            'حذف شد!',
            'کاربر با موفقیت از این دپارتمان حذف شد',
            'success'
          );           
        }).catch(error => {
          this.checkError(error);
        });        
      }).catch(error => {
          this.checkError(error);
      });       
    },        
    fetchPagesDetails: function (page) {
      this.pagination = {
        total: page['total'],
        per_page: page['per_page'],
        from: page['from'],
        to: page['to'],
        current_page: page['current_page'],
        last_page: page['last_page'],
      };

    },
    changePage: function (page,orderbyValue) {
      this.getUsers(page,'');
    },    
  },
  computed: {
    isActived () {
      return this.pagination.current_page;
    },
    pagesNumber () {
      if (!this.pagination.to) {
          return [];
      }
      let from = this.pagination.current_page - this.offset;
      if (from < 1) {
          from = 1;
      }
      let to = from + (this.offset * 2);
      if (to >= this.pagination.last_page) {
          to = this.pagination.last_page;
      }
      let pagesArray = [];
      while (from <= to) {
          pagesArray.push(from);
          from++;
      }
      return pagesArray;    
    }
  }
};
</script>
<style>
.modal-backdrop  {
    z-index: 999 !important;
}
.swal2-container{
  z-index: 10500 !important;
}
</style>