<template>
  <section class="h-100 gradient-form">
    <div :class="{'container-md': true, 'py-5': !isWidget, 'pb-2': isWidget, 'pt-4': isWidget, 'h-100': true}">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div :class="{'rounded-3': true, 'text-black': true, 'card-background': true, 'row': true}">
            <div
                :class="{'align-items-center': isWidget,
                'widget-logo-container': isWidget, 'logo': true, 'col-sm': true
            }">
              <!--<h2 v-show="step===1" class="col widget-step-name" v-if="isWidget">Payment details</h2>
              <h2 v-show="step===2 && firstTime" class="col widget-step-name" v-if="isWidget">Contact information</h2>
              <h2 v-show="step===paymentRequisitesStep" class="col widget-step-name" v-if="isWidget">Payment requisites</h2>
              <h2 v-show="step===paymentConfirmationStep" class="col widget-step-name" v-if="isWidget">Payment confirmation</h2>
              --><div :class="{'col': isWidget}">
                  <img :src="asset('/images/logo3.png')"
                       :class="{'widget-logo': isWidget, 'usual-logo': !isWidget, 'col': true}" alt="logo">
                  <!--<h4 class="mt-1 mb-5 pb-1">Payment</h4>-->
                </div>
            </div>

            <div class="support text-end me-4 col-sm">
              <a href="https://t.me/MIXPAY_SUPPORT" target="_blank" class="btn button-support btn-block fa-lg me-2 gradient-custom-2">Support</a>
              <button v-if="$store.state.auth.authenticated" class="btn button-support btn-block fa-lg me-2 gradient-custom-2"
                      @click="logout">Logout
              </button>
            </div>
          </div>

          <div class="row g-0">
            <div class="col-lg-12">
              <div class="card-body p-md-5 mx-md-4">
                <section class="section-form">
                  <div class="section-form-stepper">
                    <div class="step" :class="{'step-active' : step === 1, 'step-done': step > 1}">
                      <svg
                          xmlns="http://www.w3.org/2000/svg"
                          xmlns:xlink="http://www.w3.org/1999/xlink"
                          width="25px" height="25px">
                        <image  x="0px" y="0px" width="25px" height="25px"  xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABp1BMVEX/agD/aQD/agD/aQD/agD/aQD/aQD/agD/aQD/agD/agD/agD/aQD/aQD/aQD/agD/aQD/agD/agD/aQD/aQD/agD/aQD/aQD/aQD/aQD/aQD/aQD/agD/agD/agD/aQD/agD/aQD/agD/aQD/aQD/agD/agD/aQD/agD/aQD/aQD/aQD/aQD/aQD/agD/agD/aQD/aQD/aQD/agD/aQD/agD/agD/agD/aQD/aQD/agD/aQD/aQD/agD/aQD/aQD/aQD/aQD/aQD/aQD/agD6ZABcIABeIQD2YgCUNwBNGQBJFwBKGACWOQA0DwAAAABGFgCxRAARAgApCgCfPQDhWAAzDgA2EADaVgD/ZwBoJgAkBwAiCAAhBwAiBwBsJwDyYABQGwBRGwDsXgCGMgBAEwA/EwA/FAA+EwBAFACHMwAmCAA6EQCrQgAcBQAxDQClPwDrXQBCFADlWwD/aAB3KwAwDQAvDAAuDAAvDQB6LADoXABFFQDhWQB2KwAyDQB5LQAZBACjPwAoCgA7EgD0YQBYHgBaHgDtXwCKNABMGQCMNQD///8VrdjRAAAAQ3RSTlMAAAtHhrDW7fn51kgLAUip9vZS0FAjuiNX8ViEhAGUmIdZ8fJS0UeoqPeGstfs1/dJ0VO6uyRYWYeUWlskqqoM7vrY3V9LFAAAAAFiS0dEjGwL0kMAAAAHdElNRQfnCQcWAgKTwQc+AAAC7ElEQVQ4y21Vh19TQQy+K0XA8h5KpVgQQREVylAExQmYuAB5zjooOGlxKyIFV90D/2lv5EZb8vrLvdfL5b7Ll1wY4+phUnPOYjXx2i119Q11W2vjiUauppTmnAb6ZEHYtA0AAZRC3N4UBr4Z43Ydb06SmVRqAEzucPPGr5CWFJCQHaJ6T7Vyg9L4ZzvTIGdRaetcfqbbuEWqXoJ2NN4QfFH/7Ao0cI2hY7cPwKGhxdhJ1kp1aQg2DuCjlkOX8cx5G53FP5e3lVR7jOfWvfo4iAgVRmg26m7VceCp8uNUwVf2Ke25mSbOnb9wEeDS1PT0zPSMFDlOXdbrEPZJv0GStp+NoitwNaoUJDp7AhG2/UgbXYui63Cj2tgACgXoAwbuzeyt23jn7lxufj6XWxB6YWE+N3fPgj/IWKwXwQQLLcfVFAH0NmoUiBQ7AC/iZksT+xrWZ5MHXRbRZsSg8RZnGXAWlnF0DDkuMcP6PUb8FzRHoE3F0M8G7PT9Bw8fAT5ezBfy+SXx5AuFpcKTp877AGuwufgsip7Di81IoYysZ/UW08soegWvq4xdhjRoGEreLC6/xZV3q8W19bWieNbWxdvqe5ulAsYgGrpt7js20PEjxkEZOj8SLlB+Her1GRaHsoz32UZ/rfjFWQibCrqKskwlWGzIIworAXkJAEMxlaLazYflj59g5fNsqZQtlbTKZrNfzDmxSVRKwmTQ1ygqwrfqOCMl1CFZVocJxPco+rEJgwZeTyDLu5kO8/PX7z+AfzdMrSrZ+GfAD+vL+gj6x7YBLKdoRN/4vKXbRctnw4959yjdSOxoZcWVXzVSHdOXnfQ95teJx4W1HaOLUfoOjmPZ3jpcaO07A2pF6h4N2sssK7KjvcP2FC0n0kAXqV+o8it9klF7Y8y0lVMjzsSrXRwZpQ5l2oTuL8M9JtSuFSaHqQEyHQ2HvSNxutdCFsPQmTAwOJntg3qNHMfDvszgxOTkxNlMVzjOuHMr9H+il6R7EfMl7AAAAABJRU5ErkJggg==" />
                      </svg>
                    </div>
                    <div class="step" :class="{'step-active' : step === 2, 'step-done': step > 2}">
                      <svg v-show="step===1"
                          xmlns="http://www.w3.org/2000/svg"
                          xmlns:xlink="http://www.w3.org/1999/xlink"
                          width="25px" height="25px">
                        <image  x="0px" y="0px" width="25px" height="25px"  xlink:href="data:img/png;base64,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" />
                      </svg>

                      <svg v-show="step>=2"
                          xmlns="http://www.w3.org/2000/svg"
                          xmlns:xlink="http://www.w3.org/1999/xlink"
                          width="25px" height="25px">
                        <image  x="0px" y="0px" width="25px" height="25px" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAB8lBMVEX/aQD/agD/aQD/aQD/aQD/aQD/aQD/aQD/agD/aQD/aQD/aQD/agD/aQD/agD/aQD/aQD/agD/aQD/agD/aQD/aQD/aQD/agD/aQD/agD/aQD/aQD/agD/aQD/aQD/aQD/aQD/agD/agD/agD/aQD/agD/agD/aQD/agD/aQD/agD/agD/agD/aQD/aQD/agD/agD/aQD/aQD/agD/aQD/agD/agD/agD/aQDcVwBtJwBVHQBoJAAGAAAFAABoJQB6LQA0DgA1DwB7LQBqJgAjBwAjCABrJgCEMQBuJwBAEwBvKAB/LgBvJwBTHAA6EQAfBgAHAQAeBgBTHAD/agD/aQD/aACcOwBFFgAYBAAPAgAiCABeIAC9SQDGTgAhBwAAAABRHAD7ZADLUAAkBwD6ZAADAABVHQB5LADTVAAOAgBrJwDeVwA7EgDBSwAsCgDcVwAJAgBmJABxKQD4YgBIFwC/SgAaBQD8ZQC+SgAWBABGFgD1YgCIMwAoCQABAAAHAQBBFACyRQDJTwB7LgBbHwBLFwAbBAAFAAAsCwBUHQBeIQCSNwDiWQCsQgAxDQBYHQDXVQDtXwBEFQDUUwAKAQBJGADdVwD/ZgALAQBiIgAXBABUHAC4SAD4YwBIGACcPAACAAD+ZQDZVQAqCwD////en01hAAAAVHRSTlMAAAtHhrDW7flIAan29qlS0NBQI7pX8ViEAZSYh4dYWSPx8lLRR0ioqPcLhrKy19fs7Pn3SVO6uySjucSU/v6WQ+3tQ4v39osCfON8F3zG6Pn++cdAXIMqAAAAAWJLR0SlLrlKLwAAAAd0SU1FB+cJBxYLJecJCRwAAAK7SURBVDjLhZUHVxQxEIAncJRbVFBO5FAEEQsIImev2EVAEc2oYItiV+xi91DB3ht2Rf2hZlI2uwe3zstLspsvk8nMJAFgDIAqagBycmN5+QWFhQX5ebF4Do0YAIzQN8HMixeN4yiFc1k4jp8Q9ywRxEmKS1CTEqWWPiZOYqSJCMYcW5pQjCncfmCi1CnVNIPJZUqZtsIW1S+bAlo3MxZ55WbEiDaDG7486QxgzKvgDrQ9v+E41WPWZIBp/oZkvXvP3u6effsPBDbKK41iOWe68ZYaOXhIaDl8xPchYpW2mUH1DLWWYnmv8OWovxrHmmrjk4TSqlUfO+5gcQKdJPQei7mJBM04KYJyijsDZxLslQQ2h6dD8JmAX2pl5NksbYRyKj8bYkWfjQ1Vs6XRc+xk+nEuDJ/nAY/PlTlZZ7dHciFTcyCmdfWQG4iVbC+G4EvcRQsxF2KGMuVyCO5Fl4kc50GDyRkz/0qQveqyhHqNMN/lDwn2O/badQyeA2yCBaHUlN0bNw1767aNlBlphhRm0njnbloM3LsfGqBpKQv7J+TB4NDDR0I8fvL02fMXDqc6Bc3ayyaML1+FvPH6jb8cJzPcBhHfvhOZMmiPllTYBI3oH+T3H8Ro+ej20wAx/xwPizGlz3dIDOLcRPDT57Fh8cXqjstEMuYPiWzSr121sJ5SVK0ynJUVX7WhRTKf4zqzvmWHxXcFL5LHKllL9I8IVvwk1XSs6MBK+FcUPEI+WKzvoyVyjZ4oWPzmuNTc+dU1iAOR8B+sWaZhBvL6GvkPXGUuJElX8u5ouFJrVbdjsuJvJLzcM5e5muCtiGJXeuHnClatzoauaWHhJ0WqX7tubHb9Bsh4CJXyjZtGo5u3gH3UmLHZvEOtW9tCLky3tbeCe0z8h9M+Wx3btnfu6Eqnu3Z27mrvCC4ve/8AFx4c6dD5cHAAAAAASUVORK5CYII=" />
                      </svg>
                    </div>
                    <div class="step" :class="{'step-active' : step === 3, 'step-done': step > 3}">
                      <svg v-show="step<3"
                          xmlns="http://www.w3.org/2000/svg"
                          xmlns:xlink="http://www.w3.org/1999/xlink"
                          width="25px" height="25px">
                        <image  x="0px" y="0px" width="25px" height="25px"  xlink:href="data:img/png;base64,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" />
                      </svg>
                      <svg v-show="step>=3"
                          xmlns="http://www.w3.org/2000/svg"
                          xmlns:xlink="http://www.w3.org/1999/xlink"
                          width="25px" height="25px">
                        <image  x="0px" y="0px" width="25px" height="25px" xlink:href="data:img/png;base64,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" />
                      </svg>
                    </div>
                    <div v-if="this.firstTime" class="step"
                         :class="{'step-active' : step === 4, 'step-done': step > 4}">
                      <svg v-show="step<4"
                          xmlns="http://www.w3.org/2000/svg"
                          xmlns:xlink="http://www.w3.org/1999/xlink"
                          width="25px" height="25px">
                        <image  x="0px" y="0px" width="25px" height="25px"  xlink:href="data:img/png;base64,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" />
                      </svg>
                      <svg v-show="step>=4"
                          xmlns="http://www.w3.org/2000/svg"
                          xmlns:xlink="http://www.w3.org/1999/xlink"
                           width="25px" height="25px">
                        <image  x="0px" y="0px" width="25px" height="25px" xlink:href="data:img/png;base64,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" />
                      </svg>
                    </div>
                  </div>

                  <div class="col-12" v-if="Object.keys(validationErrors).length > 0">
                    <div class="alert alert-danger">
                      <ul class="mb-0">
                        <li v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</li>
                      </ul>
                    </div>
                  </div>

                  <p v-if="step===1" :class="{'p-4': !isWidget, 'p-1': isWidget, 'tournament-description': true}">
                    The support of our tournament will help to attract more attention to the problems of people
                    with disabilities and will contribute to their integration into society.
                  </p>

                  <h2 v-show="step===1" class="col widget-step-new" v-if="isWidget">Payment details</h2>
                  <transition name="slide-fade">
                    <form v-show="step===1" action="javascript:void(0)" @submit.prevent="next"
                          :class="{'row': true, 'col-10': !isMobile, 'col-12': isMobile, 'm-auto': true}" method="post">
                      <div :class="{'widget-form-font': isWidget, 'widget-form': true}">
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
                          <input type="number" step="0.000000001" name="amount" v-model.number="amount" id="amount" class="form-control"/>
                        </div>
                      </div>

                      <div class="text-center pt-1 mb-5 pb-1">
                        <button v-show="amount !== null" type="submit" :disabled="processing"
                                class="button-next btn btn-block fa-lg gradient-custom-2 mb-3">
                          <svg
                              xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink" width="10em">
                            <image  x="0px" y="0px"  width="10em"  xlink:href="data:img/png;base64,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" />
                          </svg>

                        </button>
                        &nbsp;
                      </div>
                    </form>
                  </transition>

                  <h2 v-show="this.firstTime && step===2" class="col widget-step-new" v-if="isWidget">Contact details</h2>
                  <transition name="slide-fade">
                    <form v-if="!$store.state.auth.authenticated && this.firstTime && step===2"
                          action="javascript:void(0)" @submit.prevent="next"
                          :class="{'row': true, 'col-10': !isMobile, 'col-12': isMobile, 'm-auto': true}" method="post">
                      <div :class="{'widget-form-font': isWidget, 'widget-form': true}">
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
                      </div>
                      <div class="text-center pt-1 mb-5 pb-1  ">
                        <button type="button" @click="prev" :disabled="processing"
                                class="button-prev btn btn-block fa-lg gradient-custom-2 mb-3">
                          <svg
                              xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink"
                              width="4em">
                            <image  x="0px" y="0px" width="4em" xlink:href="data:img/png;base64,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" />
                          </svg>
                        </button>
                        &nbsp;
                        <button type="submit" :disabled="processing"
                                class="button-next btn btn-block fa-lg gradient-custom-2 mb-3">
                          <svg
                              xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink" width="10em">
                            <image x="0px" y="0px"  width="10em"  xlink:href="data:img/png;base64,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" />
                          </svg>

                        </button>
                      </div>
                    </form>
                  </transition>

                  <h2 v-show="step===paymentRequisitesStep" class="col widget-step-new requisites-step-new" v-if="isWidget">Payment details</h2>
                  <transition name="slide-fade">
                    <form v-show="step===paymentRequisitesStep" action="javascript:void(0)" @submit.prevent="next"
                          :class="{'row': true, 'col-10': !isMobile, 'col-12': isMobile, 'm-auto': true, 'widget-form-font': isWidget}" method="post">
                      <div :class="{'form-outline': true, 'requisites-widget-container': isWidget}">
                        <Requisites v-bind="requisitesProps"></Requisites>
                      </div>
                      <div class="text-center pt-1 mb-5 pb-1  ">
                        <button type="button" @click="prev" :disabled="processing"
                                class="button-prev btn btn-block fa-lg gradient-custom-2 mb-3">
                          <svg
                              xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink"
                              width="4em">
                            <image  x="0px" y="0px" width="4em" xlink:href="data:img/png;base64,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" />
                          </svg>
                        </button>
                        &nbsp;
                        <button type="submit" :disabled="processing"
                                class="button-next btn btn-block fa-lg gradient-custom-2 mb-3">
                          <svg
                              xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink" width="10em">
                            <image x="0px" y="0px"  width="10em"  xlink:href="data:img/png;base64,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" />
                          </svg>

                        </button>
                      </div>
                    </form>
                  </transition>

                  <h2 v-show="step===paymentConfirmationStep" class="col widget-step-new" v-if="isWidget">Payment confirmation</h2>
                  <transition name="slide-fade">
                    <form ref="addImageForm" v-show="step===paymentConfirmationStep" action="javascript:void(0)"
                          @submit.prevent="pay"
                          :class="{'row': true, 'col-10': !isMobile, 'col-12': isMobile, 'm-auto': true, 'widget-form-font': isWidget}" method="post">

                      <div class="confirmation-form-inner">
                        <strong class="d-block pb-4">Attach a receipt confirming the payment:</strong>
                        <input required type="file" ref="fileupload" class="form-control" v-on:change="onFileChange"/>
                      </div>

                      <div class="text-center pt-1 mb-5 pb-1">
                        <button type="button" @click="prev" :disabled="processing"
                                class="button-prev btn btn-block fa-lg gradient-custom-2 mb-3">
                          <svg
                              xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink"
                              width="4em">
                            <image  x="0px" y="0px" width="4em" xlink:href="data:img/png;base64,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" />
                          </svg>
                        </button>
                        &nbsp;
                        <button type="submit" :disabled="processing"
                                class="button-next-2 btn btn-block fa-lg gradient-custom-2 mb-3">
                          <svg
                              xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink"
                              width="10em">
                            <image   x="0px" y="0px"  width="10em"  xlink:href="data:img/png;base64,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" />
                          </svg>
                        </button>
                      </div>
                    </form>
                  </transition>


                  <transition name="slide-fade">
                    <div v-show="step===paymentThanksStep">
                      <h2 class="col widget-step-new thank-you-step">Thank you for your donation</h2>
                      <p v-show="payment_id" :class="{'p-4': !isWidget, 'donation-description': true, 'donation-description-mb': !isWidget}">
                        Your payment id: {{this.payment_id}}
                        <br/>
                        Payment details and information about your account have been sent to your email address.
                      </p>
                      <div class="text-center pt-1 mb-5 pb-1">
                        <button :disabled="processing" @click="toAuthorizedPayment"
                                class="button-next-3 btn btn-block fa-lg gradient-custom-2 mb-3">
                          <svg
                              xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink" width="12em">
                            <image x="0px" y="0px"  width="12em"  xlink:href="data:img/png;base64,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" />
                          </svg>
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
      payment_id: null,
      file: null,
      user: {
        phone: "",
        email: ""
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
      this.payment_id = null
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
      }

      await axios.post(this.url, formData, config).then(({data}) => {
        this.validationErrors = {}
        this.payment_id = data.payment_id
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

        case "Ziraat Bank (EUR)":
          this.currency = 'EUR'
          break
        case "Ziraat Bank (USD)":
          this.currency = 'USD'
          break
        case "Ziraat Bank (TRY)":
          this.currency = 'TRY'
          break

        case "MayBank (IDR)":
          this.currency = 'IDR'
          break
        case "MayBank (USD)":
          this.currency = 'USD'
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

      console.log('issuer: ' + this.issuer + ', currency: ' + this.currency)
    },
  },
  computed: {
    isMobile: function () {
      return window.screen.availWidth <= 540
    },
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
      let qrAssetDemo = this.asset('/images/1.png')
      let data = null;

      switch (this.issuer) {
        case "Kasikorn Bank":
          data = {
            number: '161-8-74206-3',
            name: 'CRYSTAL X CO., LTD.'
          }
          break;

        case "True Wallet":
          data = {
            number: '161-8-74206-3',
            name: 'CRYSTAL X CO., LTD.'
          }
          break;

        case "Sberbank":
          data = {
            number: '2202-2036-6197-5724',
            name: 'Иван Васильевич Д.'
          }
          break;

        case "Tinkoff Bank":
          data = {
            number: '2200-7001-7704-5027',
            name: 'Анна Анатольевна Ч.'
          }
          break;

        case "Raiffeisen Bank":
          data = {
            number: '2200-3001-0026-6285',
            name: 'Иван Васильевич Д.'
          }
          break;

        case "RSHB":
          data = {
            number: '6234-4620-0496-7615',
            name: 'Антон Олегович Г.'
          }
          break;

        case "BKS":
          data = {
            number: '2203-6203-2094-5609',
            name: 'Антон Олегович Г.'
          }
          break;

        case "SBP":
          data = {
            number: '+79677966642 Система быстрых платежей (Тинькофф)',
            name: 'Елена Александровна Г.'
          }
          break;

        case "ЮMoney":
          data = {
            number: '0x5ff12b5b19168ef4c06cabda2dca0bd3bb426148',
            name: 'Елена Александровна Г.'
          }
          break;

        case "Jusan Bank":
          data = {
            number: '5395-4515-0779-8087',
            name: 'ANTON GIRENKO'
          }
          break;

        case "Halyk Bank":
          data = {
            number: '5522-0433-4789-3339',
            name: 'ANTON GIRENKO'
          }
          break;

        case "Kaspi.kz":
          data = {
            number: '4400-4302-3150-3027',
            name: 'ANTON GIRENKO'
          }
          break;

        case "BCC.KZ":
          data = {
            number: '4628-1888-8673-4679',
            name: 'ANTON GIRENKO'
          }
          break;

        case "Bereke Bank":
          data = {
            number: '4263-4333-4563-2738',
            name: 'ANTON GIRENKO'
          }
          break;

        case "Ziraat Bank (TRY)":
          data = {
            number: 'TR03 0001 0090 1040 7797 2050 01',
            name: 'Pavel Tikhonov'
          }
          break;

        case "Ziraat Bank (USD)":
          data = {
            number: 'TR73 0001 0090 1040 7797 2050 02',
            name: 'Pavel Tikhonov'
          }
          break;

        case "Ziraat Bank (EUR)":
          data = {
            number: 'TR46 0001 0090 1040 7797 2050 03',
            name: 'Pavel Tikhonov'
          }
          break;

        case "MayBank (USD)":
          data = {
            number: '5104-8111-0723-3797',
            name: 'ANTON GIRENKO'
          }
          break;

        case "MayBank (IDR)":
          data = {
            number: '5104-8131-0255-9432',
            name: 'ANTON GIRENKO'
          }
          break;

        case "BNB":
          data = {
            number: '9112-3980-1040-9153',
            name: 'MAKSIM SABLIN'
          }
          break;

        case "EGRIP":
          data = {
            number: '3001909330011728/9153',
            name: 'BY44BLNB30143001909330011728'
          }
          break;

        case "Binance Pay":
          data = {
            number: 'ID: 21552799'
          }
          break;

        case "Bitcoin":
          data = {
            number: '15buBy2NmK1aVaq5dgA5a7tXFicqRw7E91'
          }
          break;

        case "Ethereum ERC20":
          data = {
            number: 'x5ff12b5b19168ef4c06cabda2dca0bd3bb426148'
          }
          break;

        case "Telegram Wallet":
          data = {
            number: '@mixpay_support'
          }
          break;

        case "USDT Tether BEP20":
          data = {
            number: '0x5ff12b5b19168ef4c06cabda2dca0bd3bb426148'
          }
          break;

        case "USDT Tether TRC20":
          data = {
            number: 'TRHt4mxa39BwzgmwdBjS7hCqaF67JWqptA'
          }
          break;

        case "USDT Tether ERC20":
          data = {
            number: '0x80079a4937e2b89e564030d3a9aaf87ae14d1996'
          }
          break;

        default:
          data = {
            reqimage: qrAssetDemo
          }
      }

      data['issuer'] = this.issuer
      data['currency'] = this.currency
      data['amount'] = this.amountx

      return data
    }
  },
  created() {
    let isWidget = this.$route.query.widget
    let isDebug = this.$route.query.debug

    document.getElementById('custom-body').style.background = 'url("/images/back.png") left top';
    document.getElementById('custom-body').style.backgroundSize = '50%';

    if (isWidget === undefined) {
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

@font-face {
  font-family: "Montserrat";
  src: url('fonts/static/Montserrat-Regular.ttf');
  font-weight: 400;
  font-style: normal;
}

@font-face {
  font-family: "Montserrat";
  src: url('fonts/static/Montserrat-Bold.ttf');
  font-weight: 700;
  font-style: normal;
}

@font-face {
  font-family: "Montserrat";
  src: url('fonts/static/Montserrat-SemiBold.ttf');
  font-weight: 600;
  font-style: normal;
}

@font-face {
  font-family: "Montserrat";
  src: url('fonts/static/Montserrat-Bold.ttf');
  font-weight: 600;
  font-style: normal;
}

@font-face {
  font-family: "Montserrat";
  src: url('fonts/static/Montserrat-Thin.ttf');
  font-weight: 100;
  font-style: normal;
}


* {
  font-family: Montserrat, sans-serif !important;
}

.card {

}

.gradient-custom-2 {
  /**
   *
   */
}

.widget-logo-container {
  margin-bottom: 2em;
}

body {
  overflow-x: hidden !important;
}

.widget-logo {
  width: 100%;
}

.usual-logo {
  width: auto;
}

.btn.btn-primary {
  margin-top: 1em;
  border: 2px solid black;
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
  font-size: 1.2em;
}

.requisites-widget-container p {
  margin-bottom: 0 !important;
}


.row {
  .logo, .support {
    width: auto;
  }

  .support {
    margin-top: 2.1em;
  }
}

@media (min-width: 300px) and (max-width: 499px) {
  .widget-logo {
    width: 50%;
  }

  .row .support {
    margin-top: 0.2em;
  }



  .donation-description-mb {
    margin-bottom: 0;
  }

  .logo .text-logo {
    font-size: 0.9em;
  }

  .widget-form-font {
    font-size: 0.9em;
  }

  h2.widget-step-new {
    width: 80%;
    margin: 1em auto;
  }
}

@media (min-width: 500px) and (max-width: 768px) {
  .widget-logo {
    width: 50%;
  }

  .row .support {
    margin-top: 0.2em;
  }

  .donation-description-mb {
    margin-bottom: 0;
  }

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

  h2.widget-step-new {
    width: 80%;
    margin: 1em auto;
  }
}

@media (min-width: 769px) {
  .widget-logo {
    width: 20%;
  }

  .row .support {
    margin-top: 0;
  }

  .donation-description-mb {
    margin-bottom: 0;
  }

  .gradient-custom-2 {
    border-top-right-radius: .3rem;
    border-bottom-right-radius: .3rem;
  }

  .payment-info {
    width: 600px;
  }

  h2.widget-step-new {
    width: 80%;
    margin-top: 1em;
    margin-bottom: 1em;
  }
}

@media (min-width: 300px) and (max-width: 769px) {
  .row .logo {
    width: 30%;

    img {
      width: 100%;
    }
  }

  .card-background {
    margin-bottom: 1em;
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
    color: black;
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
      background: repeating-linear-gradient(
        to right,
        transparent,
        transparent 2px,
        black 5px,
        black 5px
      );
      width: calc(100% - 20px);
    }

    .step {
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 2;
      color: $color-gray;
      border-radius: 50%;
      min-width: 25px;
      min-height: 25px;
      line-height: 20px;
      font-size: 16px;

      &-active {
        color: $brand-primary;
        background-color: transparent;
        border: 1px solid black;
        height: 45px;
        border-radius: 50%;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        width: 45px;
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

.card-background {
  background: none;
  justify-content: space-between;
}


.widget-form {
  background: #ff5b03;
  opacity: 0.9;
  border-radius: 20px;
  padding: 2em;

  .form-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('/images/angle_arrow_2.png'), url('/images/back.png'); /* Два фона */
    background-repeat: no-repeat, repeat; /* Отключаем повторение фона для изображения стрелки */
    background-position: right 0.75em center, 0 0; /* Позиция изображения стрелки и фона */
    background-size: 15px auto, auto; /* Размер изображения стрелки и фона */
    //border: 1px solid #ccc;
    //padding: 5px 30px 5px 10px;
    //border-radius: 4px;
    position: relative;
    cursor: pointer;
  }

  input {
    background-image: url('/images/back.png'); /* Два фона */
    background-repeat: repeat; /* Отключаем повторение фона для изображения стрелки */
    background-position: 0 0; /* Позиция изображения стрелки и фона */
    background-size: auto; /* Размер изображения стрелки и фона */
  }
}

.button-support {
  background: #ff5b03;
  color: #ffeadc;
  font-size: 0.8em;
  padding: 0.7em 2em;
}

.button-next {
  position: relative;
  opacity: 0.9;
}

.button-next::after {
  position: absolute;
  content: 'Next';
  font-size: 1.2em;
  right: 4em;
  top: 1em;
}

.button-next::before {
  position: absolute;
  right: 0.8em;
  top: 2.1em;
  content: '';
  background: url('/images/arrow-next.png') no-repeat center center/cover;
  padding-right: 1.5em;
  padding-bottom: 1.5em;
}

.button-next-2 {
  position: relative;
  opacity: 0.9;
}

.button-next-2::after {
  position: absolute;
  content: 'Pay';
  color: #f5e0d1;
  font-size: 1.2em;
  right: 4em;
  top: 1em;
}

.button-next-2::before {
  position: absolute;
  right: 0.8em;
  top: 2.1em;
  content: '';
  background: url('/images/arrow-yellow.png') no-repeat center center/cover;
  padding-right: 1.5em;
  padding-bottom: 1.5em;
}

.button-next-3 {
  position: relative;
  opacity: 0.9;
}

.button-next-3::after {
  position: absolute;
  content: 'Make another donation';
  color: #f5e0d1;
  font-size: 0.9em;
  right: 2em;
  padding: 0 2em;
  top: 1em;
}

.button-next-3::before {
  position: absolute;
  right: 1em;
  top: 2.6em;
  content: '';
  background: url('/images/arrow-next.png') no-repeat center center/cover;
  padding-right: 1.5em;
  padding-bottom: 1.5em;
}

h2.widget-step-new {
  border: 0.1em solid #ff5b03;
  padding: 0.5em;
  border-radius: 20px;
  color: black;
  font-size: 1em;
}

input[type=file] {
  border: 1px solid #9e4d14;
  border-radius: 1em;
}

input[type=file]::file-selector-button {
  margin-right: 20px;
  background: #ff5b03;
  padding: 10px 20px;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
}

input[type=file]::file-selector-button:hover {
  background: #e84803;
}

.confirmation-form-inner {
  background: linear-gradient(to left, rgb(255 149 35), rgb(255 172 28) 50%, rgb(255 188 6) 75%);
  padding: 3em;
  border-radius: 2em;
}


@media (min-width: 540px) {
  .section-form .widget-step-new {
    width: 40%;
    margin-top: 1em;
    margin-bottom: 1em;
    margin-left: 10% !important;
  }

  .section-form .widget-step-new.requisites-step-new {
    margin-left: 20% !important;
  }
}

.section-form .widget-step-new.thank-you-step {
  margin: 1em auto;
  width: 80%;
}

.donation-description {
  color: #ffeadc;
  background: #ff5b03;
  border: 10px;
  margin-top: 1em;
  border-radius: 5em;
  padding: 1.7em 2.5em 1.7em 2.5em;
  font-size: 1em;
  position: relative;
  width: 100%;
}

.tournament-description {
  font-size: 1em;
  font-weight: 600;
  text-align: center;
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