<template>
  <div v-if="number">
    <p><span>Account number:</span> {{number}}</p>
    <p v-if="name"><span>Payee's name:</span> {{name}}</p>
  </div>
  <div v-if="reqimage">
    <img style="width: 80%" :src="reqimage" alt="payment requisites"/>
  </div>
</template>

<script>

const Requisites = () => import('@/components/Payment/Requisites.vue');

export default {
  name: "Requisites",
  components: {Requisites},
  props: {
    number: {
      type: String,
      required: false,
      default: null
    },

    name: {
      type: String,
      required: false,
      default: null
    },

    reqimage: {
      type: String,
      required: false,
      default: null
    }
  }
}
</script>

<style scoped>
p {
  font-size: 2em;
}

.arrow-highlight {
  position: relative;
  margin: 0 0.5em;
  padding: 0 0.2em;
}

.arrow-highlight:before {
  content: "";
  z-index: -1;
  left: -0.5em;
  top: 0.1em;
  border-width: 0.5em;
  border-style: solid;
  border-color: orange;
  position: absolute;
  width: calc(100% - 0.5em);
  border-left-color: transparent;
}

.arrow-highlight:after {
  content: "";
  z-index: -1;
  right: 0;
  top: 0.1em;
  border-width: 0.5em;
  border-style: solid;
  border-color: orange;
  position: absolute;
  border-top-color: transparent;
  border-bottom-color: transparent;
  border-left-color: transparent;
  transform: rotate(180deg);
  transform-origin: center right;
}
</style>