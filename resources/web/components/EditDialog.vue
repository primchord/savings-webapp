<template>
  <div id="overlay">
    <div id="content">
      <span class="dli-close" @click="clickEvent"></span>
      <p><slot></slot></p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showContent: false,
    }
  },
  methods: {
    openModal() {
      this.showContent = true
    },
    closeModal() {
      this.showContent = false
    },
    clickEvent() {
      this.$emit('from-child')
    },
  },
}
</script>

<style scoped>
#overlay {
  z-index: 1;

  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);

  display: flex;
  align-items: center;
  justify-content: center;
}
#content {
  z-index: 10;
  width: 55%;
  padding: 0.5em;
  background: #fff;
}

.dli-close {
  display: inline-block;
  vertical-align: middle;
  color: #333;
  line-height: 1;
  width: 1.5em;
  height: 0.1em;
  background: currentColor;
  border-radius: 0.1em;
  position: relative;
  transform: rotate(45deg);
  justify-items: right;
  cursor: pointer;
}

.dli-close::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: inherit;
  border-radius: inherit;
  transform: rotate(90deg);
}
</style>
