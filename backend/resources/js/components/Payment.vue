<template>
  <section class="h-100 gradient-form">
    <div :class="{'container-md': true, 'py-5': !isWidget, 'pb-2': isWidget, 'pt-4': isWidget, 'h-100': true}">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div :class="{'card': !isWidget, 'rounded-3': true, 'text-black': true}">
            <div class="text-end me-4">
              <a href="https://t.me/MIXPAY_SUPPORT" class="btn btn-primary btn-block fa-lg me-2 gradient-custom-2">SUPPORT</a>
              <button v-if="$store.state.auth.authenticated" class="btn btn-primary btn-block fa-lg gradient-custom-2"
                      @click="logout">LOGOUT
              </button>
            </div>

            <div class="row g-0">
              <div class="col-lg-12">
                <div class="card-body p-md-5 mx-md-4">

                  <div
                      :class="{'row': isWidget, 'align-items-center': isWidget, 'widget-logo-container': isWidget, 'logo': true, 'text-center': true}">
                    <h2 v-show="step===1" class="col widget-step-name" v-if="isWidget">Payment details</h2>
                    <h2 v-show="step===2 && !firstTime" class="col widget-step-name" v-if="isWidget">Contact information</h2>
                    <h2 v-show="step===paymentRequisitesStep" class="col widget-step-name" v-if="isWidget">Payment requisites</h2>
                    <h2 v-show="step===paymentConfirmationStep" class="col widget-step-name" v-if="isWidget">Payment confirmation</h2>
                    <div :class="{'col': isWidget}">
                      <img :src="asset('images/logo.png')"
                           :class="{'widget-logo': isWidget, 'usual-logo': !isWidget, 'col': true}" alt="logo">
                      <!--<h4 class="mt-1 mb-5 pb-1">Payment</h4>-->
                      <div :class="{'text-logo': true, 'mini-margin-top': isWidget}">PAYMENT SYSTEMS</div>
                    </div>
                  </div>
                  <p v-if="step===1" :class="{'p-4': !isWidget, 'p-1': isWidget, 'donation-description': true, 'donation-description-mb': !isWidget}">
                    The support of our tournament will help to attract more attention to the problems of people
                    with disabilities and will contribute to their integration into society.
                  </p>

                  <section class="section-form">
                    <div class="section-form-stepper">
                      <div class="step" :class="{'step-active' : step === 1, 'step-done': step > 1}"><span
                          class="step-number">1</span></div>
                      <div class="step" :class="{'step-active' : step === 2, 'step-done': step > 2}"><span
                          class="step-number">2</span></div>
                      <div class="step" :class="{'step-active' : step === 3, 'step-done': step > 3}"><span
                          class="step-number">3</span></div>
                      <div v-if="this.firstTime" class="step"
                           :class="{'step-active' : step === 4, 'step-done': step > 4}"><span
                          class="step-number">4</span></div>
                    </div>

                    <div class="col-12" v-if="Object.keys(validationErrors).length > 0">
                      <div class="alert alert-danger">
                        <ul class="mb-0">
                          <li v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</li>
                        </ul>
                      </div>
                    </div>

                    <transition name="slide-fade">
                      <form v-show="step===1" action="javascript:void(0)" @submit.prevent="next"
                            :class="{'row': true, 'col-8': true, 'm-auto': true, 'widget-form-font': isWidget}" method="post">
                        <h2 v-if="!isWidget">Payment details</h2>
                        <div v-if="!isDebug" :class="{'form-outline': true, 'mb-4': !isWidget, 'mb-3': isWidget}">
                          <label for="donation_type" class="col-sm-12 control-label">Select donation type</label>
                          <select required name="donation_type" id="donation_type"
                                  class="form-select donation-type-select" v-model.number="donation_type">
                            <option selected disabled value="1">
                              Basketball championship among the disabled people
                            </option>
                          </select>
                        </div>

                        <div :class="{'form-outline': true, 'mb-4': !isWidget, 'mb-3': isWidget}">
                          <label for="issuer" class="col-sm-12 control-label">Select payment method</label>
                          <select required name="issuer" id="issuer"
                                  class="form-select" v-model="issuer">
                            <option value="" selected disabled>
                              Bank transfer (Thailand):
                            </option>

                            <option value="Kasikorn Bank">
                              Kasikorn Bank
                            </option>

                            <option value="" disabled>
                              Bank transfer (Russia):
                            </option>
                            <option value="Sberbank">
                              Sberbank
                            </option>
                            <option value="Tinkoff Bank">
                              Tinkoff Bank
                            </option>
                            <option value="Raiffeisen Bank">
                              Raiffeisen Bank
                            </option>
                            <option value="RSHB">
                              RSHB
                            </option>
                            <option value="BKS">
                              BKS
                            </option>
                            <option value="SBP">
                              SBP System Fast Payas
                            </option>

                            <option value="" disabled>
                              Bank transfer (Kazakhstan):
                            </option>
                            <option value="Jusan Bank">
                              Jusan Bank
                            </option>
                            <option value="Halyk Bank">
                              Halyk Bank
                            </option>
                            <option value="Kaspi.kz">
                              Kaspi.kz
                            </option>
                            <option value="BCC.KZ">
                              BCC.KZ
                            </option>
                            <option value="Bereke Bank">
                              Bereke Bank
                            </option>

                            <option value="" disabled>
                              Bank transfer (Belarus):
                            </option>
                            <option value="BNB">
                              BNB
                            </option>
                            <option value="EGRIP">
                              EGRIP
                            </option>

                            <option value="" disabled>
                              Bank transfer (Turkey):
                            </option>
                            <option value="Ziraat Bank (TRY)">
                              Ziraat Bank (TRY)
                            </option>
                            <option value="Ziraat Bank (USD)">
                              Ziraat Bank (USD)
                            </option>
                            <option value="Ziraat Bank (EUR)">
                              Ziraat Bank (EUR)
                            </option>

                            <option value="" disabled>
                              Bank transfer (Indonesia):
                            </option>
                            <option value="MayBank (USD)">
                              MayBank (USD)
                            </option>
                            <option value="MayBank (IDR)">
                              MayBank (IDR)
                            </option>
                            <!--
                                                        <option value="" disabled>
                                                          Payment services (Thailand):
                                                        </option>
                                                        <option value="True Wallet">
                                                          True Wallet
                                                        </option>

                                                        <option value="" disabled>
                                                          Payment services (Russia):
                                                        </option>
                                                        <option value="ЮMoney">
                                                          ЮMoney
                                                        </option>-->

                            <option value="" disabled>
                              Payment services (World):
                            </option>
                            <option value="Binance Pay">
                              Binance Pay
                            </option>
                            <option value="Telegram Wallet">
                              Telegram Wallet
                            </option>

                            <option value="" disabled>
                              Cryptocurrencies:
                            </option>

                            <option value="Bitcoin">
                              Bitcoin
                            </option>
                            <option value="Ethereum ERC20">
                              Ethereum ERC20
                            </option>
                            <option value="USDT Tether BEP20">
                              USDT Tether BEP20
                            </option>
                            <option value="USDT Tether TRC20">
                              USDT Tether TRC20
                            </option>
                            <option value="USDT Tether ERC20">
                              USDT Tether ERC20
                            </option>
                          </select>
                        </div>

                        <div v-show="issuer !== null && donation_type !== null" :class="{'form-outline': true, 'mb-4': !isWidget, 'mb-3': isWidget}">
                          <label for="amount" class="col-sm-12 control-label">Enter {{ this.currency }} amount</label>
                          <input type="number" name="amount" v-model.number="amount" id="amount" class="form-control"/>
                        </div>

                        <div class="text-center pt-1 mb-5 pb-1">
                          <button v-show="amount !== null" type="submit" :disabled="processing"
                                  class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">
                            {{ processing ? "Please wait" : "Next" }}
                          </button>
                          &nbsp;
                          <!--<a class="text-muted" href="#!">Forgot password?</a>-->
                        </div>
                      </form>
                    </transition>


                    <transition name="slide-fade">
                      <form v-if="!$store.state.auth.authenticated && this.firstTime && step===2"
                            action="javascript:void(0)" @submit.prevent="next"
                            :class="{'row': true, 'col-8': true, 'm-auto': true, 'widget-form-font': isWidget}" method="post">
                        <h2 v-if="!isWidget">Contact information</h2>
                        <div :class="{'form-outline': true, 'mb-4': !isWidget, 'mb-3': isWidget}">
                          <input required type="phone" name="phone" v-model="user.phone" id="phone"
                                 class="form-control"/>
                          <label class="form-label" for="phone">Phone</label>
                        </div>

                        <div :class="{'form-outline': true, 'mb-4': !isWidget, 'mb-3': isWidget}">
                          <input required type="email" name="email" v-model="user.email" id="email" class="form-control"
                                 placeholder="example@mail.com"/>
                          <label class="form-label" for="email">Email</label>
                        </div>

                        <div :class="{'form-outline': true, 'mb-4': !isWidget, 'mb-3': isWidget}">
                          <input required type="password" name="password" v-model="user.password" id="password"
                                 class="form-control"/>
                          <label class="form-label" for="password">Password</label>
                        </div>

                        <!--                        <div class="form-outline mb-4">-->
                        <!--                          <input type="password" name="password_confirmation" v-model="user.password_confirmation"-->
                        <!--                                 id="password_confirmation"-->
                        <!--                                 class="form-control"/>-->
                        <!--                          <label class="form-label" for="password_confirmation">Password confirmation</label>-->
                        <!--                        </div>-->

                        <div class="text-center pt-1 mb-5 pb-1">
                          <button type="button" @click="prev" :disabled="processing"
                                  class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">
                            {{ processing ? "Please wait" : "Back" }}
                          </button>
                          &nbsp;
                          <button type="submit" :disabled="processing"
                                  class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">
                            {{ processing ? "Please wait" : "Next" }}
                          </button>
                          &nbsp;
                          <!--<a class="text-muted" href="#!">Forgot password?</a>-->
                        </div>
                      </form>
                    </transition>


                    <transition name="slide-fade">
                      <form v-show="step===paymentRequisitesStep" action="javascript:void(0)" @submit.prevent="next"
                            :class="{'row': true, 'col-10': true, 'm-auto': true, 'widget-form-font': isWidget}" method="post">
                        <h2 v-if="!isWidget">Payment requisites</h2>
                        <p class="pt-1 donation-description">
                          Open the mobile banking or payment system application. Transfer {{ amount }} {{ currency }}
                          to the following payment details ({{this.issuer}}):
                        </p>
                        <div :class="{'form-outline': true, 'mb-4': !isWidget, 'requisites-widget-container': isWidget}">
                          <Requisites v-bind="requisitesProps"></Requisites>
                        </div>

                        <p class="donation-description">
                          If needed, you can leave a comment for the payment.
                          <br/>
                          <br/>ATTENTION! After making the payment, take a screenshot of the transaction or save the
                          receipt, then return to the payment form and press the PAY button.
                        </p>
                        <div class="text-center pt-1 mb-5 pb-1">
                          <button type="button" @click="prev" :disabled="processing"
                                  class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">
                            {{ processing ? "Please wait" : "Back" }}
                          </button>
                          &nbsp;
                          <button type="submit" :disabled="processing"
                                  class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">
                            {{ processing ? "Please wait" : "Next" }}
                          </button>
                          &nbsp;
                        </div>
                      </form>
                    </transition>


                    <transition name="slide-fade">
                      <form ref="addImageForm" v-show="step===paymentConfirmationStep" action="javascript:void(0)"
                            @submit.prevent="pay"
                            :class="{'row': true, 'col-8': true, 'm-auto': true, 'widget-form-font': isWidget}" method="post">
                        <h2 v-if="!isWidget">Payment confirmation</h2>
                        <strong>Attach a receipt confirming the payment:</strong>
                        <input required type="file" ref="fileupload" class="form-control" v-on:change="onFileChange"/>

                        <div class="text-center pt-1 mb-5 pb-1">
                          <button type="button" @click="prev" :disabled="processing"
                                  class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">
                            {{ processing ? "Please wait" : "Back" }}
                          </button>
                          &nbsp;
                          <button type="submit" :disabled="processing"
                                  class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">
                            {{ processing ? "Please wait" : "Pay" }}
                          </button>
                          &nbsp;
                        </div>
                      </form>
                    </transition>


                    <transition name="slide-fade">
                      <div v-show="step===paymentThanksStep">
                        <h2>Thanks for the donation!</h2>

                        <div class="text-center pt-1 mb-5 pb-1">
                          <button :disabled="processing" @click="toAuthorizedPayment"
                                  class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">
                            {{ processing ? "Please wait" : "Make another donation" }}
                          </button>
                        </div>
                      </div>
                    </transition>

                  </section>
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
import Requisites from "@/components/Payment/Requisites.vue";

function debounce(fn, wait) {
  let timer;
  return function (...args) {
    if (timer) {
      clearTimeout(timer); // clear any pre-existing timer
    }
    const context = this; // get the current context
    timer = setTimeout(() => {
      fn.apply(context, args); // call the function if time expires
    }, wait);
  }
}

export default {
  name: 'register',
  components: {Requisites},
  data() {
    return {
      steps: {},
      step: 1,
      donation_type: 1,
      currency: null,
      issuer: null,
      amount: null,
      file: null,
      user: {
        phone: "",
        email: "",
        password: "",
        password_confirmation: ""
      },
      validationErrors: {},
      processing: false,
      paymentCompleted: false,
      firstTime: true,
      isWidget: false,
      isDebug: false
    }
  },
  methods: {
    ...mapActions({
      signIn: 'auth/loginWithoutRedirect',
      signOut: "auth/logout"
    }),

    async logout() {
      await axios.post('/api/logout').then(({data}) => {
        this.signOut()
        this.toAuthorizedPayment()
        this.firstTime = true
      })
    },

    toAuthorizedPayment() {
      this.steps = {}
      this.step = 1
      this.currency = null
      this.issuer = null
      this.amount = null
      this.file = null
      this.validationErrors = {}
      this.processing = false
      this.paymentCompleted = false
      this.firstTime = false
      this.$refs.addImageForm.reset()
      this.$refs.fileupload.value = null
    },

    onFileChange(e) {
      this.file = e.target.files[0];
    },

    asset(path) {
      let base_path = window._asset || '';
      return base_path + path;
    },

    prev() {
      this.step--;
    },

    next() {
      this.step++;
    },

    async pay() {
      this.processing = true
      await axios.get('/sanctum/csrf-cookie')

      const config = {
        headers: {'content-type': 'multipart/form-data'}
      }

      let formData = new FormData();
      formData.append('file', this.file);
      formData.append('payment_method', this.issuer);
      formData.append('payment_amount', this.amount);

      if (this.currency) {
        formData.append('currency', this.currency);
      }

      if (!this.$store.state.auth.authenticated && this.firstTime) {
        formData.append('phone', this.user.phone);
        formData.append('email', this.user.email);
        formData.append('password', this.user.password);
      }

      await axios.post(this.url, formData, config).then(({data}) => {
        this.validationErrors = {}

        if (!this.$store.state.auth.authenticated && this.firstTime) {
          this.signIn(data)
          this.paymentCompleted = true;
        }
      }).catch((data) => {
        if (data.response.status === 422 && !this.firstTime) {
          this.validationErrors = data.response.data.errors
        } else {
          this.validationErrors = {}
          alert(data.data.message)
        }
      }).finally(() => {
        this.processing = false
      })

      if (Object.keys(this.validationErrors).length === 0) {
        this.step++;
      }
    }
  },
  watch: {
    issuer(newValue, oldValue) {
      switch (newValue) {
        case "Kasikorn Bank":
        case "True Wallet":
          this.currency = 'THB'
          break

        case "Sberbank":
        case "Tinkoff Bank":
        case "Raiffeisen Bank":
        case "RSHB":
        case "BKS":
        case "SBP":
        case "ЮMoney":
          this.currency = 'RUB'
          break

        case "Jusan Bank":
        case "Halyk Bank":
        case "Kaspi.kz":
        case "BCC.KZ":
        case "Bereke Bank":
          this.currency = 'KZT'
          break

        case "BNB":
        case "EGRIP":
          this.currency = 'BYN'
          break

        case "Ziraat Bank":
          this.currency = 'TRY'
          break

        case "MayBank":
          this.currency = 'IDR'
          break

        case "Bitcoin":
          this.currency = 'BTC'
          break

        case "Ethereum ERC20":
          this.currency = 'ETH'
          break

        case "USDT Tether BEP20":
        case "USDT Tether TRC20":
        case "USDT Tether ERC20":
          this.currency = 'USDT'
          break

        default:
          this.currency = null
          break
      }
    },
  },
  computed: {
    paymentRequisitesStep: function () {
      if (this.$store.state.auth.authenticated && !this.firstTime) {
        return 2;
      } else {
        return 3;
      }
    },
    paymentConfirmationStep: function () {
      if (this.$store.state.auth.authenticated && !this.firstTime) {
        return 3;
      } else {
        return 4;
      }
    },
    paymentThanksStep: function () {
      if (this.$store.state.auth.authenticated && !this.firstTime) {
        return 4;
      } else {
        return 5;
      }
    },
    url: function () {
      if (this.$store.state.auth.authenticated && !this.firstTime) {
        return '/api/payment';
      } else {
        return '/api/payment-register';
      }
    },
    requisitesProps: function () {
      let qrAssetDemo = this.asset('images/1.png')

      switch (this.issuer) {
        case "Kasikorn Bank":
          return {
            number: '161-8-74206-3',
            name: 'CRYSTAL X CO., LTD.'
          }

        case "True Wallet":
          return {
            number: '161-8-74206-3',
            name: 'CRYSTAL X CO., LTD.'
          }

        case "Sberbank":
          return {
            number: '2202-2036-6197-5724',
            name: 'Иван Васильевич Д.'
          }

        case "Tinkoff Bank":
          return {
            number: '2200-3001-0026-6285',
            name: 'Иван Васильевич Д.'
          }

        case "Raiffeisen Bank":
          return {
            number: '2200-3001-0026-6285',
            name: 'Иван Васильевич Д.'
          }

        case "RSHB":
          return {
            number: '6234-4620-0496-7615',
            name: 'Антон Олегович Г.'
          }

        case "BKS":
          return {
            number: '2203-6203-2094-5609',
            name: 'Антон Олегович Г.'
          }

        case "SBP":
          return {
            number: '+79677966642 Система быстрых платежей (Тинькофф)',
            name: 'Елена Александровна Г.'
          }

        case "ЮMoney":
          return {
            number: '0x5ff12b5b19168ef4c06cabda2dca0bd3bb426148',
            name: 'Елена Александровна Г.'
          }

        case "Jusan Bank":
          return {
            number: '5395-4515-0779-8087',
            name: 'ANTON GIRENKO'
          }

        case "Halyk Bank":
          return {
            number: '5522-0433-4789-3339',
            name: 'ANTON GIRENKO'
          }

        case "Kaspi.kz":
          return {
            number: '4400-4302-3150-3027',
            name: 'ANTON GIRENKO'
          }

        case "BCC.KZ":
          return {
            number: '4628-1888-8673-4679',
            name: 'ANTON GIRENKO'
          }

        case "Bereke Bank":
          return {
            number: '4263-4333-4563-2738',
            name: 'ANTON GIRENKO'
          }

        case "Ziraat Bank (TRY)":
          return {
            number: 'TR03 0001 0090 1040 7797 2050 01',
            name: 'Pavel Tikhonov'
          }

        case "Ziraat Bank (USD)":
          return {
            number: 'TR73 0001 0090 1040 7797 2050 02',
            name: 'Pavel Tikhonov'
          }

        case "Ziraat Bank (EUR)":
          return {
            number: 'TR46 0001 0090 1040 7797 2050 03',
            name: 'Pavel Tikhonov'
          }

        case "MayBank (USD)":
          return {
            number: '5104-8111-0723-3797',
            name: 'ANTON GIRENKO'
          }

        case "MayBank (IDR)":
          return {
            number: '5104-8131-0255-9432',
            name: 'ANTON GIRENKO'
          }

        case "BNB":
          return {
            number: '9112-3980-1040-9153',
            name: 'MAKSIM SABLIN'
          }

        case "EGRIP":
          return {
            number: '3001909330011728/9153',
            name: 'BY44BLNB30143001909330011728'
          }

        case "Binance Pay":
          return {
            number: 'ID: 21552799'
          }

        case "Bitcoin":
          return {
            number: '15buBy2NmK1aVaq5dgA5a7tXFicqRw7E91'
          }

        case "Ethereum ERC20":
          return {
            number: 'x5ff12b5b19168ef4c06cabda2dca0bd3bb426148'
          }

        case "Telegram Wallet":
          return {
            number: '@mixpay_support'
          }

        case "USDT Tether BEP20":
          return {
            number: '0x5ff12b5b19168ef4c06cabda2dca0bd3bb426148'
          }

        case "USDT Tether TRC20":
          return {
            number: 'TRHt4mxa39BwzgmwdBjS7hCqaF67JWqptA'
          }

        case "USDT Tether ERC20":
          return {
            number: '0x80079a4937e2b89e564030d3a9aaf87ae14d1996'
          }

        default:
          return {
            reqimage: qrAssetDemo
          }
      }
    }
  },
  created() {
    let isWidget = this.$route.query.widget
    let isDebug = this.$route.query.debug

    if (isWidget === undefined) {
      document.getElementById('custom-body').style.backgroundColor = '#eee';
      this.isWidget = false
    }

    if (isWidget === 'true') {
      this.isWidget = true
    }

    if (isDebug === undefined) {
      this.isDebug = false
    }

    if (isDebug === 'true') {
      this.isDebug = true
    }

    if (this.$store.state.auth.authenticated) {
      this.firstTime = false
    }
  },
}
</script>

<style lang="scss">
.gradient-custom-2 {
  /* fallback for old browsers */
  background: #fccb90;

  /* Chrome 10-25, Safari 5.1-6 */
  background: -webkit-linear-gradient(to right, #DD7C45, #DD7C45, #D76546, #D76546);

  /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  background: linear-gradient(to right, #DD7C45, #DD7C45, #D76546, #D76546);
}

.widget-logo-container {
  margin-top: 1em;
  margin-bottom: 2em;
}

body {
  overflow-x: hidden !important;
}

.widget-logo {
  width: 40%;
}

.usual-logo {
  width: 24%;
}

.btn.btn-primary {
  margin-top: 1em;
  border: 2px solid black;
}

.donation-description {
  font-weight: 700;
  margin-top: 1em;
}

.donation-description-mb {
  margin-bottom: 3em;
}

.donation-type-select {
  max-width: 100%;
  white-space: normal;
  /* For Firefox: */
  text-overflow: ellipsis;
}

.widget-step-name {
  margin-left: 2em;
  border: 0.05em solid black;
  padding: 0.7em;
  border-radius: 8px;
  font-size: 1.2em;
  color: rgba(121, 113, 113, 0.99);
}

.requisites-widget-container {
  font-size: 0.7em;
}

.requisites-widget-container p {
  margin-bottom: 0 !important;
}

@media (min-width: 300px) and (max-width: 499px) {
  .logo .text-logo {
    font-size: 0.9em;
  }

  .widget-form-font {
    font-size: 0.9em;
  }
}

@media (min-width: 500px) and (max-width: 768px) {
  .logo .text-logo {
    margin-bottom: 2em;
    margin-top: -1.5em;
  }

  .logo .text-logo.mini-margin-top {
    font-size: 1em !important;
  }

  .widget-form-font {
    font-size: 1em;
  }
}

@media (min-width: 769px) {
  .gradient-custom-2 {
    border-top-right-radius: .3rem;
    border-bottom-right-radius: .3rem;
  }

  .payment-info {
    width: 600px;
  }
}

$brand-primary: #ff6400;
$brand-secondary: #dedc00;
$brand-lemon: #fff219;
$brand-quaternary: #f282a5;
$brand-menthol: #c3500a;
$brand-coral: rgb(250, 90, 85);
$brand-paprika: rgb(205, 0, 125);
$color-white: #fff;
$color-dark: #676767;
$color-gray: #cecece;
$color-lightgray: #ededed;
$color-jungle: #193805;

/* FONT */
$font-montserrat: "Montserrat", sans-serif;
$font-weight-bold: 700;


.logo .text-logo.mini-margin-top {
  margin-top: -0.2em;
  font-size: 0.5em;
}


.pen-description {
  display: flex;
  flex-flow: column;
  align-items: center;
  font-family: $font-montserrat;

  h1 {
    text-align: center;
    margin-top: 2rem;
    color: $color-white;
  }

  p {
    margin: 0;
    line-height: 1;
  }

  .pen-copyright {
    img {
      border-radius: 25px;
      padding: 5px;
      margin: 5px;
      transition: box-shadow .5s ease-in-out;
    }

    &:hover img {
      box-shadow: 0 10px 20px #0e2101;
    }
  }
}

.section-form {
  h2 {
    text-align: center;
    color: rgba(121, 113, 113, 0.99);
    line-height: 1.2;
    font-weight: 500;
    font-size: 34px;
    margin-bottom: 40px;
  }

  &-stepper {
    display: flex;
    justify-content: space-between;
    width: 100%;
    position: relative;
    margin: 0 auto 1.5em;

    &::before {
      z-index: 0;
      content: "";
      display: block;
      position: absolute;
      height: 2px;
      top: calc(50% - 1px);
      background: $color-gray;
      width: calc(100% - 20px);
    }

    .step {
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 2;
      border: 2px solid $color-gray;
      color: $color-gray;
      background-color: $color-white;
      border-radius: 50%;
      min-width: 25px;
      min-height: 25px;
      line-height: 20px;
      font-size: 16px;

      &-active {
        color: $brand-primary;
        background-color: $color-white;
        border-color: $brand-primary;
      }

      &-done {
        color: #ff9f5a;
        border-color: #ff9a4f;
      }

      &-number {
        font-family: $font-montserrat;
        font-weight: 800;
        line-height: 1;
        vertical-align: middle;
      }
    }
  }

  // Transition SLIDE FADE
  .slide-fade-enter-active {
    transition: all 0.4s ease-out;
  }

  .slide-fade-leave-active {
    display: none;
    transition: all 0.4s cubic-bezier(1, 0.5, 0.8, 1);
  }

  .slide-fade-enter-from, .slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
  }
}

.tokens-amt, h4.loading {
  font-size: 1.5em !important;
}

span[class^="dot-"] {
  opacity: 0;
}

.dot-one {
  animation: dot-one 2s infinite linear
}

.dot-two {
  animation: dot-two 2s infinite linear
}

.dot-three {
  animation: dot-three 2s infinite linear
}

@keyframes dot-one {
  0% {
    opacity: 0;
  }
  15% {
    opacity: 0;
  }
  25% {
    opacity: 1;
  }
  100% {
    opacity: 1;
  }
}

@keyframes dot-two {
  0% {
    opacity: 0;
  }
  25% {
    opacity: 0;
  }
  50% {
    opacity: 1;
  }
  100% {
    opacity: 1;
  }
}

@keyframes dot-three {
  0% {
    opacity: 0;
  }
  50% {
    opacity: 0;
  }
  75% {
    opacity: 1;
  }
  100% {
    opacity: 1;
  }
}
</style>