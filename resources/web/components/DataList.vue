<template>
  <div>
    <div class="container">
      <table>
        <thead>
          <tr>
            <th
              v-for="(title, i) in items"
              :key="i"
              :class="[i == 0 ? '' : 'nav']"
            >
              {{ title }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(list, i) in allDataList" :key="i">
            <td>
              <input v-model="checked" :value="i" type="radio" />
            </td>
            <td class="align-left">{{ list.item }}</td>
            <td class="align-right">¥{{ list.price.toLocaleString() }}</td>
            <td>{{ list.remark }}</td>
            <td>
              <div v-if="checked === i">
                <button class="btn04" @click="openModal(list)">編集</button>
                <button class="btn04" @click="deleteAction(list.id)">
                  削除
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td class="align-right">合計</td>
            <td class="align-right">
              <span class="total"> ¥{{ total.toLocaleString() }}</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <edit-dialog v-show="showContent" @from-child="closeModal">
      <input v-model="item" type="text" placeholder="項目" />
      <input v-model="price" type="number" placeholder="金額" />
      <input v-model="remark" type="text" placeholder="備考" />
      <input
        type="submit"
        value="更新"
        :disabled="!formValid"
        @click="updateAction()"
    /></edit-dialog>
  </div>
</template>

<script>
import axios from 'axios'
import EditDialog from './EditDialog.vue'
export default {
  name: 'DataListComponent',
  components: {
    EditDialog,
  },
  props: {
    allDataList: {
      type: Array,
      required: true,
    },
    total: {
      type: Number,
      required: true,
    },
    selected: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      items: ['', '項目', '金額', '備考', '編集'],
      checked: '',
      showContent: false,
      id: undefined,
      item: '',
      price: Number,
      remark: '',
    }
  },
  computed: {
    formValid() {
      return this.item && this.price
    },
  },
  methods: {
    openModal(list) {
      this.showContent = true
      this.id = list.id
      this.item = list.item
      this.price = list.price
      this.remark = list.remark
    },
    closeModal() {
      this.showContent = false
    },
    async updateAction() {
      const url = 'api/update'
      const data = {
        id: this.id,
        item: this.item,
        price: this.price,
        remark: this.remark,
      }
      await axios.post(url, data)
      this.init()
    },
    async deleteAction(id) {
      const res = window.confirm('この項目を削除しますか？')
      const url = `api/delete/${id}`
      if (res) {
        await axios.get(url)
        this.init()
      }
    },
    init() {
      this.$router.go({ path: this.$router.currentRoute.path, force: true })
    },
  },
}
</script>

<style scoped>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

table {
  /* max-width: 700px; */
  text-align: center;
  margin: 3px auto;
  margin-bottom: 3rem;
}

td {
  padding-left: 0.5rem;
  height: 40px;
}

h1 {
  text-align: center;
  margin-top: 1rem;
  margin-bottom: 1rem;
}

h2 {
  font-size: 1.2rem;
  margin-top: 2rem;
}

.title {
  max-width: 700px;
  margin-top: 1rem;
  margin: 0 auto;
}

.align-right {
  text-align: right;
  padding-right: 0.5rem;
}

.align-left {
  text-align: left;
}

.total {
  background-color: #333;
  color: #fff;
  font-size: 1.2rem;
}

.nav {
  min-width: 180px;
  text-align: center;
  background-color: lightseagreen;
  height: 50px;
  line-height: 50px;
  margin-right: 2px;
  color: #333;
}

.btn-flat-border {
  display: inline-block;
  text-decoration: none;
  color: #122;
  border: none;
  background: lightseagreen;
}

.btn04:hover {
  background-color: lightseagreen;
  border: 2px solid lightseagreen;
  color: #fff;
  box-sizing: border-box;
  transition: all 0.3s;
}
.btn04 {
  margin-right: 0.2rem;
  margin-left: 0.2rem;
  padding: 0.3em 1em;
  background-color: transparent;
  border: 2px solid lightseagreen;
  border-radius: 3px;
  color: lightseagreen;
  cursor: pointer;
}

input {
  font-size: 18px;
  padding: 0.2em 0.3em;
  border-radius: 3px;
  border: none;
  background: #efefef;
}
input[type='submit'] {
  font-size: 18px;
  padding: 0.2em 1em;
  border: none;
  background: lightseagreen;
  color: #fff;
}
input[type='submit'][disabled] {
  opacity: 0.4;
}
</style>
