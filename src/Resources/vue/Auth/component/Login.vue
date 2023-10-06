<template>
  <div class="row justify-content-md-center">
    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
      <form method="post" name="login" :action="redirect" ref="loginForm">
      </form>
      <div class="login-screen">
        <div class="login-box">
          <a href="#" class="login-logo">
            <img :src="getAppUrl() + '/templates/Wafi_Admin/img/logo-dark.png'" alt="Wafi Admin Dashboard">
          </a>
          <h5 v-html="translateText('welcomeMessage')"></h5>
          <div class="form-group">
            <input type="text" class="form-control" :placeholder="translateText('usernamePlaceholder')" v-model="username" autocomplete="username" minlength="3" required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" :placeholder="translateText('passwordPlaceholder')" v-model="password" autocomplete="current-password" minlength="6" required>
          </div>
          <div class="actions mb-4">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="remember_pwd">
              <label class="custom-control-label" for="remember_pwd">{{ translateText('rememberMe') }}</label>
            </div>
            <button type="button" class="btn btn-primary" @click="userLogin">{{ translateText('loginButton') }}</button>
          </div>
          <div class="forgot-pwd">
            <button class="btn-link" @click="showAlert('attention', 'accessDenied', 'error', 'close')">{{ translateText('forgotPassword') }}</button>
          </div>
          <hr>
          <div class="actions align-left">
            <span class="additional-link">{{ translateText('signUpMessage') }}</span>
            <button class="btn btn-dark" @click="showAlert('attention', 'accessDenied', 'error', 'close')">{{ translateText('signUpButton') }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        username: '',
        password: '',
      };
    },
    methods: {
      userLogin() {
        axios.post('api/auth', {
          action: 'loginCheck',
          _token: this.getToken(),
          username: this.username,
          password: this.password,
        })
        .then(response => {
          //window.location.href = 'auth?action=mainAuth&type=login'; // هدایت به صفحه home
          location.reload(); // رفرش صفحه
        })
        .catch(error => {
          this.checkError(error);
        });
      },
    },
    components: {},
  };
</script>
