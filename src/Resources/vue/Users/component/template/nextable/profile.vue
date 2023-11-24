<template>
  <div class="card card-body overflow-hidden" :data-backround-image="getAppUrl()+'/Templates/nextable/default/assets/media/image/profile-bg.png'" :style="'background: url(&quot;'+getAppUrl()+'Templates/nextable/default/assets/media/image/profile-bg.png&quot;);'">
		<div class="p-3 d-lg-flex align-items-center justify-content-between">
		  <div class="d-flex align-items-center">
			  <div>
				  <figure class="avatar avatar-xl mr-3">
					  <img :src="getAppUrl()+'media/images/Users/Profile/noImage.png'" class="rounded-circle" alt="...">
					</figure>
				</div>
				<div class="text-white">
				  <h3 class="line-height-30 m-b-10">
            <a href="#" data-toggle="tooltip" title="" class="font-size-15 text-white btn-floating m-l-5 align-middle" data-original-title="ویرایش پروفایل">
              <i class="fa fa-user"></i>
              {{getSafe(() =>current_user.name)}} {{getSafe(() =>current_user.last_name)}}
            </a>
				  </h3>
					<p class="mb-0 opacity-8">{{current_user.username}}</p>
				</div>
			</div>
      <div>
        <ul class="list-inline text-center">
          <li class="list-inline-item my-2">
            <a href="#" class="text-success d-inline-block">
              <h2 class="font-weight-bold mb-2 primary-font line-height-36">418</h2>
              <span>تعداد کلیک</span>
            </a>
          </li>
          <li class="list-inline-item my-2">
            <a href="#" class="text-warning d-inline-block ml-3">
              <h2 class="font-weight-bold mb-2 primary-font line-height-36">1,596</h2>
              <span>دانلود‌ها</span>
            </a>
          </li>
          <li class="list-inline-item my-2">
            <a href="#" class="text-info d-inline-block ml-3">
              <h2 class="font-weight-bold mb-2 primary-font line-height-36">7,896</h2>
              <span>اعتبار</span>
            </a>
          </li>
        </ul>
      </div>
		</div>
	</div>

  <div class="card">
		<div class="card-body">
      <ul class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">
        <li class="flex-sm-fill text-sm-center nav-item">
          <a class="nav-link active" id="userinfo-tab" data-toggle="tab" href="#userinfo" role="tab" aria-selected="false">اطلاعات کاربری</a>
        </li>
        <li class="flex-sm-fill text-sm-center nav-item">
          <a class="nav-link" id="password-tab1" data-toggle="tab" href="#password" role="tab" aria-selected="false">
            تغییر رمز عبور
          </a>
        </li>
        <li class="flex-sm-fill text-sm-center nav-item">
          <a class="nav-link" id="earnings-tab" data-toggle="tab" href="#earnings" role="tab" aria-selected="false">سطوح دسترسی</a>
        </li>
        <li class="flex-sm-fill text-sm-center nav-item">
          <a class="nav-link" id="hometimeline-tab" data-toggle="tab" href="#timeline" role="tab" aria-selected="true">تاریخچه فعالیت</a>
        </li>        
      </ul>
      <div class="tab-content p-t-30" id="myTabContent">
        <div class="tab-pane fade show active" id="userinfo" role="tabpanel">
          <div class="row">

            <div class="col-sm-12 col-md-6">
              <div class="form-group">
                <label for="name">نام</label>
                <input type="text" class="form-control text-left" id="name" v-model="current_user.name" readonly placeholder="نام خود را وارد کنید" dir="rtl">
              </div> 
            </div>

            <div class="col-sm-12 col-md-6">
              <div class="form-group">
                <label for="last_name">نام خانوادگی</label>
                <input type="text" class="form-control text-left" id="last_name" v-model="current_user.last_name" readonly placeholder="نام خانوادگی خود را وارد کنید" dir="rtl">
              </div> 
            </div> 

            <div class="col-sm-12 col-md-6">
              <div class="form-group">
                <label for="username">نام کاربری</label>
                <input type="text" class="form-control text-left" id="username" v-model="current_user.username" readonly placeholder="نام کاربری خود را وارد کنید" dir="rtl">
              </div> 
            </div>  

          </div>         
        </div>
        <div class="tab-pane fade" id="password" role="tabpanel">
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <div class="form-group">    
                <label for="current_password">رمز عبور:</label>
                <input type="password" class="form-control text-left" v-model="current_password" id="current_password" placeholder="رمز عبور" dir="ltr">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <div class="form-group">    
                <label for="password">رمز عبور جدید:</label>
                <input type="password" class="form-control text-left" v-model="password" id="password" placeholder="رمز عبور جدید" dir="ltr">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <div class="form-group">    
                <label for="password_confirmation">تکرار عبور جدید:</label>
                <input type="password" class="form-control text-left" v-model="password_confirmation" id="password_confirmation" placeholder="تکرار رمز عبور جدید" dir="ltr">
              </div>
            </div>
          </div>
          <button class="btn btn-primary" type="button" @click="upatePassword">ارسال درخواست</button>
        </div>
      </div>
    </div>
  </div>
 
</template>

<script>
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      current_user:[],
      current_password:'',
      password:'',
      password_confirmation:''
    };
  },
  
  mounted() {
    this.getCurrentUser();
  },  
  methods: {
    upatePassword(){
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'upatePassword';          
        const current_password = this.current_password
        const password = this.password
        const password_confirmation = this.password_confirmation
        axios.request({
          method: 'put',
          url: this.getAppUrl() + 'api/profile',
          headers: {'Authorization': `Bearer ${token}`},
          data: { 'action': action, 'current_password':current_password,'password':password,'password_confirmation':password_confirmation}
        }).then(response => {
          Swal.fire(
            'صادر شد!',
            'رمز جدید شما با موفقیت صادر شد.',
            'success'
          );           
        }).catch(error => {
          this.checkError(error);
        }); 
      }).catch(error => {
          this.checkError(error);
      });            
    },
    getCurrentUser(){
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        axios.request({
          method: 'GET',
          url: this.getAppUrl() + 'api/profile?action=getCurrentUser',
          headers: {'Authorization': `Bearer ${token}`}
        }).then(response => {
          this.current_user = response.data.CurrentUser;
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
          this.checkError(error);
      });    
    },
  },
  computed: {

  }
};
</script>
