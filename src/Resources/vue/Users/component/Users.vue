<template>
  <div class="row justify-content-md-center">
    <div class="card col-sm-12">
      <div class="card-body text-left">
        <div class="form-row row">
          <div class="col-md-2 mb-2">      
            <button class="btn btn-primary" data-toggle="modal" data-target="#createdUser"><i class="fa fa-plus"></i> ایجاد کاربر جدید</button>
          </div>
          <div class="col-md-4 mb-3">   
            <input type="text" class="form-control" id="searchQuery" v-model="searchQuery" placeholder="جستجو کاربر" autocomplete="off">  
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
              <option value="0">نمایش همه سطوح دسترسی</option>
            </select>
          </div>
          <div class="col-md-2 mb-2">
            <button class="btn btn-info btn-block" @click="getUsers"><i class="fa fa-search"></i> اعمال فیلترها</button>
          </div>          
        </div>          
      </div>
    </div>
    <div class="card col-sm-12" style="margin-top: 12px;padding: 12px;">
      <table class="table table-bordered mt-4">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">شناسه</th>
            <!-- <th scope="col">تصویر</th> -->
            <th scope="col">کاربر</th>
            <th scope="col">عملیات</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in users" :key="index" :style="user.deleted_at ? 'background:antiquewhite' : ''">
            <td class="align-middle">{{(index + itemsPerPage * (pagination.current_page - 1)) + 1}}</td>
            <td >{{ user.id }}</td>
            <!-- <td>
              <img :src="userImage(user.id )" onerror="this.src='http://localhost/example-app/public/media/images/Users/Profile/noImage.png'" alt="تصویر پروفایل کاربر" width="115" height="115">
            </td> -->
            <td><b>{{ user.username  }}</b><br>{{ user.name }} {{ user.last_name }}<br>{{ user.email  }}</td>
            <td v-if="!user.deleted_at">
              <button class="btn btn-success btn-icon"  data-bs-toggle="modal" data-toggle="modal" data-bs-target="#editUser" data-target="#editUser"  @click="showEditModal(user);current_user_id = user.id" title="ویرایش">
                <i class="fa fa-edit"></i>
              </button>            
              <button class="btn btn-danger btn-icon" @click="softDeleteUser(user.id)" title="حذف">
                <i class="fa fa-trash"></i>
              </button>
              <button class="btn btn-info btn-icon" @click="showEditPasswordModal(user.id)" data-bs-toggle="modal" data-toggle="modal" data-bs-target="#myModal" data-target="#myModal">
                <i class="fa fa-key"></i>
              </button>  
              <button class="btn btn-warning btn-icon" data-bs-toggle="modal" data-toggle="modal" data-bs-target="#setAccessLevel" data-target="#setAccessLevel" @click="getUserAccessLevel(user.id);currentUserId = user.id;">
                <i class="fa fa-lock"></i>
              </button>   
              <!-- <button class="btn btn-secondary btn-icon" data-toggle="modal" data-target="#setProfileImage" @click="currentUserId = user.id;">
                <i class="fa fa-camera"></i>
              </button>                                         -->
            </td>
            <td v-else>
              <button class="btn btn-primary btn-icon" @click="restoreUser(user.id)" title="بازیابی">
                <i class="fa fa-upload"></i>
              </button>             
              <button class="btn btn-danger btn-icon" @click="deleteUser(user.id)" title="حذف">
                <i class="fa fa-trash"></i>
              </button>             
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card col-sm-12" style="margin-top: 12px;padding: 12px;" v-if="pagination.last_page != 1">
      <nav aria-label="Page navigation">
          <ul class="pagination">
              <li v-if="pagination.current_page > 1">
                  <a href="#" aria-label="Previous" class="page-link" @click.prevent="changePage(pagination.current_page - 1,orderbyValue)">
                      <span aria-hidden="true">&laquo;</span>
                  </a>
              </li>
              <li v-for="page in pagesNumber"
                  :class="[ page == isActived ? 'page-item active' : '']">
                  <a href="#" @click.prevent="changePage(page,orderbyValue)" class="page-link">{{ page }}</a>
              </li>
              <li v-if="pagination.current_page < pagination.last_page">
                  <a href="#" aria-label="Next" class="page-link"
                      @click.prevent="changePage(pagination.current_page + 1,orderbyValue)">
                      <span aria-hidden="true">&raquo;</span>
                  </a>
              </li>
          </ul>
      </nav>
    </div>
    <div id="createdUser" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-left">ایجاد کاربر</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">نام: *</label>
                  <input type="text" class="form-control" id="name" v-model="name" placeholder="نام">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="last_name">نام خانوادگی:</label>
                  <input type="text" class="form-control" id="last_name" v-model="last_name" placeholder="نام خانوادگی">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="username">نام کاربری: *</label>
                  <input type="text" class="form-control" id="username" v-model="username" placeholder="نام کاربری">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">ایمیل: *</label>
                  <input type="email" class="form-control" id="email" v-model="email" placeholder="ایمیل">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="password">رمز عبور: *</label>
                  <input type="password" class="form-control" id="password" v-model="password" placeholder="رمز عبور">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="confirm_password">تکرار رمز عبور: *</label>
                  <input type="password" class="form-control" id="confirm_password" v-model="confirm_password" placeholder="تکرار رمز عبور">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check form-switch text-left">
                  <input class="form-check-input" type="checkbox" v-model="is_active">
                  <label class="form-check-label" for="flexSwitchCheckDefault" style="padding-right:20px"><b>فعال</b></label>
                </div>                
              </div>
              <div class="col-md-6">              
                <button type="submit" class="btn btn-primary" @click="createdUser"><i class="fa fa-plus"></i> ثبت کاربر</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="editUser" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-left">ویرایش کاربر</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="edit_name">نام: *</label>
                  <input type="text" class="form-control" id="edit_name" v-model="editedName" placeholder="نام">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="edit_last_name">نام خانوادگی:</label>
                  <input type="text" class="form-control" id="edit_last_name" v-model="editedLastName" placeholder="نام خانوادگی">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="edit_username">نام کاربری: *</label>
                  <input type="text" class="form-control" id="edit_username" v-model="editedUsername" placeholder="نام کاربری">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="edit_email">ایمیل: *</label>
                  <input type="email" class="form-control" id="edit_email" v-model="editedEmail" placeholder="ایمیل">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check form-switch text-left">
                  <input class="form-check-input" type="checkbox" v-model="editedIsActive" :checked="editedIsActive">
                  <label class="form-check-label" for="flexSwitchCheckDefault" style="padding-right:20px"><b>فعال</b></label>
                </div>                
              </div>              
              <div class="col-md-6">              
                <button type="submit" class="btn btn-primary" @click="editUser"><i class="fa fa-check"></i> ذخیره تغییرات</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="setAccessLevel" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-left">ویرایش سطح دسترسی کاربر</h4>
          </div>
          <div class="modal-body">
            <div class="row justify-content-md-center">
              <div class="col-sm-4" v-for="item in permissions">
                <div class="form-check form-switch text-left">
                  <input class="form-check-input" type="checkbox" :id="'flexSwitchCheckDefault_'+item.id" :checked="checkedAccessLevel(item.id)" @change="setOrRemoveAccessLevelUser(item.id)">
                  <label class="form-check-label" for="flexSwitchCheckDefault" style="padding-right:20px"><b>{{item.name}}</b></label>
                </div>                               
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>  
    <div id="setProfileImage" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-left">ویرایش تصویر کاربر</h4>
          </div>
          <div class="modal-body">
            <form @submit.prevent="" enctype="multipart/form-data">
            <div class="row justify-content-md-center">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="profile-image">تصویر پروفایل</label>
                  <input type="file" id="file" ref="file" class="form-control-file" accept="image/*" v-on:change="previewImage">
                </div>
              </div>
              <div class="col-sm-3">                    
                <button type="submit" class="btn btn-primary" @click="uploadProfile" >آپلود</button>
              </div>  
              <div class="col-sm-3">                    
                <button type="button" class="btn btn-danger" @click="deleteProfile" >حذف</button>
              </div>                          
              <div class="col-sm-12">              
                <img v-if="imageUrl" :src="imageUrl" alt="پیش نمایش تصویر" class="img-thumbnail mb-3" style="max-width: 300px;">
              </div>
            </div>
            </form>            
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
      permissions:{},
      UserAccessLevel:[],
      users: {},
      current_user_id:'',
      name:'',
      editedName:'',
      last_name:'',
      editedLastName:'',
      username:'',
      editedUsername:'',
      email:'',
      editedEmail:'',
      password:'',
      newPassword:'',
      confirm_password:'',
      is_active:'',
      editedIsActive:'',
      editis_active:'',
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
      currentUserId:'',
      defaultImageSrc: this.getAppUrl()+'media/images/Users/Profile/noImage.png',
      imageSrc:'',
      imageUrl: null,
      userImageFile:'',
    };
  },
  mounted() {
  console.log(this.getAppUrl())
    this.getUsers();
    this.getAccessLevel();
  },  
  methods: {
    deleteProfile()
    {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'deleteUserProfile';
        const user_id = this.currentUserId;
        axios.request({
          method: 'delete', // از PUT برای ویرایش استفاده می‌کنیم
          url: this.getAppUrl() + 'api/admin/users',
          headers: {'Authorization': `Bearer ${token}`},
          data: { action, user_id }
        }).then(response => {
          Swal.fire(
            'حذف شد!',
            'تصویر پروفایل کاربر حذف شد',
            'success'
          );
          this.searchQuery = '';
          this.getUsers();          
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
        this.checkError(error);
      });    
    },
    previewImage(event) {
      this.userImageFile = this.$refs.file.files[0];

        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imageUrl = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            this.imageUrl = null;
        }
    },
    uploadProfile() {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;

        const fileInput = this.$refs.fileInput;
        const file = this.userImageFile
        if (!file) {
          return; // اگر فایلی انتخاب نشده باشد، عملیات آپلود را انجام ندهید.
        }
        // ایجاد یک فرم دیتا FormData برای ارسال فایل به سرور
        const formData = new FormData();
        formData.append('image', file); // نام فیلد باید با نام فیلد مورد انتظار در API شما مطابقت داشته باشد
        formData.append('userId', this.currentUserId); 
        formData.append('action', 'uploadUserProfile'); 

        axios.post(this.getAppUrl() + 'api/admin/users', formData, {
          headers: {
            'Content-Type': 'multipart/form-data', // تنظیم هدر مناسب برای آپلود فایل
            'Authorization': `Bearer ${token}`, // اگر نیاز دارید توکن تأیید هویت را ارسال کنید
          },
        })
        .then(response => {
          Swal.fire(
            'ویرایش شد!',
            'تصویر پروفایل کاربر ویرایش شد',
            'success'
          );        
          this.searchQuery = '';
          this.getUsers();
        })
        .catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
          this.checkError(error);
      });     

    }, 
     userImage(userId) {
      var randomNum = Date.now();
      const baseUrl = this.getAppUrl();
      return `${baseUrl}media/images/Users/Profile/${userId}.png?timestamp=${randomNum}`
    },    
    setOrRemoveAccessLevelUser(accessLevelId)
    {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'setOrRemoveAccessLevelUser';
        const user_id = this.currentUserId;
        axios.request({
          method: 'PUT', // از PUT برای ویرایش استفاده می‌کنیم
          url: this.getAppUrl() + 'api/admin/AccessLevel',
          headers: {'Authorization': `Bearer ${token}`},
          data: { action, user_id, accessLevelId }
        }).then(response => {
          Swal.fire(
            'ویرایش شد!',
            'سطح دسترسی کاربر ویرایش شد',
            'success'
          );
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
        this.checkError(error);
      });    
    },
    checkedAccessLevel(accessLevelId)
    {
      return this.UserAccessLevel.some(item => item.access_level_id === accessLevelId)
    },  
    getUserAccessLevel(userId){
      this.currentUserId = userId;
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        axios.request({
          method: 'GET',
          url: this.getAppUrl() + 'api/admin/AccessLevel?action=getUserAccessLevel&userId='+userId,
          headers: {'Authorization': `Bearer ${token}`}
        }).then(response => {
          this.UserAccessLevel = response.data.UserAccessLevel;
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
          this.checkError(error);
      });    
    },
    getAccessLevel() {   
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        axios.request({
          method: 'GET',
          url: this.getAppUrl() + 'api/admin/AccessLevel?action=getAccessLevel&itemsPerPage=-1',
          headers: {'Authorization': `Bearer ${token}`}
        }).then(response => {
          this.permissions = response.data;
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
          this.checkError(error);
      });
    },
    showEditPasswordModal(userId) {
      Swal.fire({
        title: 'فرم تغییر رمز عبور',
        html: `<input type="password" id="password" class="swal2-input" placeholder="رمز عبور">
        <input type="password" id="confirm_password" class="swal2-input" placeholder="تکرار رمز عبور">`,
        confirmButtonText: 'تغییر رمز عبور',
        focusConfirm: false,
        preConfirm: () => {
          const password = Swal.getPopup().querySelector('#password').value
          const confirm_password = Swal.getPopup().querySelector('#confirm_password').value
          if (!password || !confirm_password) {
            Swal.showValidationMessage('رمز عبور و تکرار آن الزامی است')
          }
          if (password != confirm_password) {
            Swal.showValidationMessage('رمز عبور و تکرار آن یکسان نیستند')
          }
          return { password: password, confirm_password: confirm_password }
        }
      }).then((result) => {
        axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
          const token = response.data.token;
          const action = 'changePassword';          
          const password = result.value.password
          const confirm_password = result.value.confirm_password
          axios.request({
            method: 'put',
            url: this.getAppUrl() + 'api/admin/users',
            headers: {'Authorization': `Bearer ${token}`},
            data: { 'action': action, 'password':password,'confirm_password':confirm_password,'userId':userId}
          }).then(response => {
            Swal.fire(
              'صادر شد!',
              'رمز جدید کاربر با موفقیت صادر شد.',
              'success'
            );           
          }).catch(error => {
            this.checkError(error);
          });        
        }).catch(error => {
            this.checkError(error);
        });      
      })
    },     
    getUsers(page = 1,first=1) {   
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        axios.request({
          method: 'GET',
          url: this.getAppUrl() + 'api/admin/users?action=getUsers&itemsPerPage='+this.itemsPerPage+'&searchQuery='+this.searchQuery+'&page='+page,
          headers: {'Authorization': `Bearer ${token}`}
        }).then(response => {
          this.fetchPagesDetails(response.data);        
          this.users = response.data.data;
          this.searchQuery='';
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
          this.checkError(error);
      });
    },  
    createdUser()
    {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'createdUser';
        const first_name = this.name;
        const last_name = this.last_name;
        const username = this.username;
        const email = this.email;
        const password = this.password;
        const confirm_password= this.confirm_password;
        const is_active = this.is_active;
        axios.request({
          method: 'POST',
          url: this.getAppUrl() + 'api/admin/users',
          headers: {'Authorization': `Bearer ${token}`},
          data: { action , first_name ,last_name,username,email,password,confirm_password,is_active}
        }).then(response => {
          this.searchQuery = '';
          this.getUsers();
          Swal.fire(
            'اضافه شد!',
            'کاربر با موفقیت اضافه شد',
            'success'
          );          
        }).catch(error => {
          this.checkError(error);
        });        
      }).catch(error => {
          this.checkError(error);
      });          
    },
   
    editUser() {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'updateUser';
        const first_name = this.editedName;
        const last_name = this.editedLastName;
        const username = this.editedUsername;
        const email = this.editedEmail;
        const password = this.editedPassword;
        const confirm_password = this.editedConfirmPassword;
        const is_active = this.editedIsActive;
        const user_id = this.current_user_id;
        axios.request({
          method: 'PUT', // از PUT برای ویرایش استفاده می‌کنیم
          url: this.getAppUrl() + 'api/admin/users',
          headers: {'Authorization': `Bearer ${token}`},
          data: { action, user_id, first_name, last_name, username, email, password, confirm_password, is_active }
        }).then(response => {
          this.searchQuery = '';
          this.getUsers();
          Swal.fire(
            'ویرایش شد!',
            'کاربر با موفقیت ویرایش شد',
            'success'
          );
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
        this.checkError(error);
      });
    },
    showEditModal(user) {
      this.editedName = user.name;
      this.editedLastName = user.last_name;
      this.editedUsername= user.username;
      this.editedEmail= user.email;
      this.editedIsActive = user.is_active;
    }, 
    submitSoftDeleteUser(id){
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'softDeleteUser';
        const userId = id;
        axios.request({
          method: 'delete',
          url: this.getAppUrl() + 'api/admin/users',
          headers: {'Authorization': `Bearer ${token}`},
          data: { 'action': action, 'userId':userId}
        }).then(response => {
          this.searchQuery = '';
          this.getUsers();
          Swal.fire(
            'حذف شد!',
            'کاربر با موفقیت حذف موقت شد.',
            'success'
          );           
        }).catch(error => {
          this.checkError(error);
        });        
      }).catch(error => {
          this.checkError(error);
      });       
    },
    softDeleteUser(index) {
      Swal.fire({
        title: 'آیا اطمینان دارید؟',
        text: "این کاربر به صورت موقت حذف خواهد شد!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'بله، حذف کن!',
        cancelButtonText: 'لغو'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submitSoftDeleteUser(index);
        }
      });
    },
    submitDeleteUser(id){
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'deleteUser';
        const userId = id;
        axios.request({
          method: 'delete',
          url: this.getAppUrl() + 'api/admin/users',
          headers: {'Authorization': `Bearer ${token}`},
          data: { 'action': action, 'userId':userId}
        }).then(response => {
          this.searchQuery = '';
          this.getUsers();
          Swal.fire(
            'حذف شد!',
            'کاربر با موفقیت حذف شد.',
            'success'
          );           
        }).catch(error => {
          this.checkError(error);
        });        
      }).catch(error => {
          this.checkError(error);
      });       
    },
    deleteUser(index) {
      Swal.fire({
        title: 'آیا اطمینان دارید؟',
        text: "تمام اطلاعات این کاربر به صورت کامل حذف خواهد شد!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'بله، حذف کن!',
        cancelButtonText: 'لغو'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submitDeleteUser(index);
        }
      });
    },
    submitRestoreUser(id){
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'restoreDeleteUser';
        const userId = id;
        axios.request({
          method: 'put',
          url: this.getAppUrl() + 'api/admin/users',
          headers: {'Authorization': `Bearer ${token}`},
          data: { 'action': action, 'userId':userId}
        }).then(response => {
          this.searchQuery = '';
          this.getUsers();
          Swal.fire(
            'بازیابی شد!',
            'کاربر با موفقیت بازیابی شد.',
            'success'
          );           
        }).catch(error => {
          this.checkError(error);
        });        
      }).catch(error => {
          this.checkError(error);
      });       
    },
    restoreUser(index) {
      Swal.fire({
        title: 'آیا اطمینان دارید؟',
        text: "کاربر بازیابی شود!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'بله، بازیابی کن!',
        cancelButtonText: 'لغو'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submitRestoreUser(index);
        }
      });
    },    

    checkboxMenuChanged(menuId)
    {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const accessLevelName = name;
        const action = 'updateAccessLevelMenu';
        const accessLevelId = this.AccessLevelIdSelected;
        axios.request({
          method: 'put',
          url: this.getAppUrl() + 'api/admin/AccessLevel',
          headers: {'Authorization': `Bearer ${token}`},
          data: { 'accessLevelName':accessLevelName, 'action': action, 'accessLevelId':accessLevelId,'menuId':menuId}
        }).then(response => {
        }).catch(error => {
          this.checkError(error);
        });        
      }).catch(error => {
          this.checkError(error);
      });
    },
    getMenus(accessLevelId)
    {
      this.AccessLevelIdSelected = accessLevelId
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        axios.request({
          method: 'GET',
          url: this.getAppUrl() + 'api/admin/AccessLevel?action=getUsersMenus&accessLevelId='+accessLevelId,
          headers: {'Authorization': `Bearer ${token}`}
        }).then(response => {
          this.menus = response.data.menu;
          this.AccessLevelMenuId = response.data.AccessLevelMenu;
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
          this.checkError(error);
      });    
    },
    async showModal() {
      const { value: name } = await Swal.fire({
        title: this.translateText('createAccessLevel'),
        input: 'text',
        inputPlaceholder: this.translateText('accessLevelName'),
        showCancelButton: true,
        confirmButtonText: this.translateText('submit'),
        cancelButtonText: this.translateText('cancel')
      });

      if (name) {
        this.submitAccessLevel(name);
      }
    }, 
    
   
    submitAccessLevel(index) {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const accessLevelName = index;
        const action = 'createAccessLevel';

        axios.request({
          method: 'POST',
          url: this.getAppUrl() + 'api/admin/AccessLevel',
          headers: {'Authorization': `Bearer ${token}`},
          data: { accessLevelName , action }
        }).then(response => {
          this.getUsers();
          Swal.fire(
            'اضافه شد!',
            'سطح دسترسی با موفقیت اضافه شد.',
            'success'
          );          
        }).catch(error => {
          this.checkError(error);
        });        
      }).catch(error => {
          this.checkError(error);
      });
    },     
    editPersubmitAccessLevelmission(index) {

    },    
    editPermission(index) {
      this.editingIndex = index;
    },
    saveEditedPermission(name,id) {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const accessLevelName = name;
        const action = 'updateAccessLevel';
        const accessLevelId = id;
        axios.request({
          method: 'put',
          url: this.getAppUrl() + 'api/admin/AccessLevel',
          headers: {'Authorization': `Bearer ${token}`},
          data: { 'accessLevelName':accessLevelName, 'action': action, 'accessLevelId':accessLevelId}
        }).then(response => {
          this.getUsers();
          Swal.fire(
            'ویرایش شد!',
            'سطح دسترسی با موفقیت ویرایش شد.',
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
      //this.getUsers(page,1,orderbyValue);
    },    
    setMouseToEdit() {
      if (!this.editingIndex) {
        this.mouseIsOver = true;
      }
    },
    resetMouse() {
      if (!this.editingIndex) {
        this.mouseIsOver = false;
      }
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
