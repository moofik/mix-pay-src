<template>
  <section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container-md py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div class="card rounded-3 text-black">
            <div class="row g-0">
              <div class="col-lg-12">
                <div class="card-body p-md-5 mx-md-4">

                  <div class="text-center">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp"
                         style="width: 185px;" alt="logo">
                    <h4 class="mt-1 mb-5 pb-1">Registration</h4>
                  </div>

                  <form action="javascript:void(0)" @submit="register" class="row col-8 m-auto" method="post">
                    <div class="col-12" v-if="Object.keys(validationErrors).length > 0">
                      <div class="alert alert-danger">
                        <ul class="mb-0">
                          <li v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</li>
                        </ul>
                      </div>
                    </div>
                    <div class="form-outline mb-4">
                      <input type="email" name="email" v-model="user.email" id="email" class="form-control"
                             placeholder="example@mail.com"/>
                      <label class="form-label" for="email">Email</label>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="password" name="password" v-model="user.password" id="password"
                             class="form-control"/>
                      <label class="form-label" for="password">Password</label>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="password" name="password_confirmation" v-model="user.password_confirmation"
                             id="password_confirmation"
                             class="form-control"/>
                      <label class="form-label" for="password_confirmation">Password confirmation</label>
                    </div>

                    <div class="text-center pt-1 mb-5 pb-1">
                      <button type="submit" :disabled="processing"
                              class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">
                        {{ processing ? "Please wait" : "Register" }}
                      </button>
                      &nbsp;
                      <!--<a class="text-muted" href="#!">Forgot password?</a>-->
                    </div>

                    <div class="d-flex align-items-center justify-content-center pb-4">
                      <p class="mb-0 me-2">Already have an account?</p>
                      <router-link class="btn btn-outline-danger" :to="{name:'login'}">Login Now!</router-link>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import {mapActions} from 'vuex'

export default {
  name: 'register',
  data() {
    return {
      user: {
        email: "",
        password: "",
        password_confirmation: ""
      },
      validationErrors: {},
      processing: false
    }
  },
  methods: {
    ...mapActions({
      signIn: 'auth/login'
    }),
    async register() {
      this.processing = true
      await axios.get('/sanctum/csrf-cookie')
      await axios.post('/api/register', this.user).then(({data}) => {
        this.validationErrors = {}
        this.signIn(data)
      }).catch(({data}) => {
        if (data.status === 422) {
          this.validationErrors = data.data.errors
        } else {
          this.validationErrors = {}
          alert(data.data.message)
        }
      }).finally(() => {
        this.processing = false
      })
    }
  }
}
</script>

<style>
.gradient-custom-2 {
  /* fallback for old browsers */
  background: #fccb90;

  /* Chrome 10-25, Safari 5.1-6 */
  background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #e20c0c);

  /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #d81212);
}

@media (min-width: 768px) {
  .gradient-form {
    height: 100vh !important;
  }
}

@media (min-width: 769px) {
  .gradient-custom-2 {
    border-top-right-radius: .3rem;
    border-bottom-right-radius: .3rem;
  }
}
</style>