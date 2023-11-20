<template>
  <div class="mb-3 fv-plugins-icon-container">
    <label for="email" class="form-label">{{translateText('username')}}:</label>
    <input type="text" class="form-control text-start" id="email" v-model="username" :placeholder="translateText('usernamePlaceholder')" autofocus="" dir="ltr">
    <div class="fv-plugins-message-container invalid-feedback"></div>
  </div>
  <div class="mb-3 form-password-toggle fv-plugins-icon-container">
    <div class="d-flex justify-content-between">
      <label class="form-label" for="password">{{translateText('password')}}:</label>
      <a style="color:blue;" @click="showAlert('attention', 'accessDenied', 'error', 'close')">
        <small>{{ translateText('forgotPassword') }}</small>
      </a>
    </div>
    <div class="input-group input-group-merge has-validation">
      <input type="password" id="password" class="form-control text-start" v-model="password" :placeholder="translateText('passwordPlaceholder')" aria-describedby="password" dir="ltr">
      <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
    </div>
    <div class="fv-plugins-message-container invalid-feedback"></div>
  </div> 
  <div class="mb-3">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="remember-me">
      <label class="form-check-label" for="remember-me"> {{ translateText('rememberMe') }} </label>
    </div>
  </div> 
  <button class="btn btn-primary d-grid w-100" @click="userLogin">{{ translateText('loginButton') }}</button> 
  <br>
  <p class="text-center">
    <span>{{ translateText('signUpMessage') }}</span>
    <a style="color:blue;" @click="showAlert('attention', 'accessDenied', 'error', 'close')">
      <span>{{ translateText('signUpButton') }}</span>
    </a>
  </p> 
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
