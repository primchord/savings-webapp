<template>
  <div>
    <header>
      <h1>収支管理アプリ</h1>
      <div class="container">
        <span>
          年間貯蓄予想額：¥{{
            (
              incomeTotal * 12 -
              monthlyPaymentTotal * 12 -
              yearPaymentTotal
            ).toLocaleString()
          }}
        </span>
      </div>
    </header>
    <div class="title">
      <h2>月収入</h2>
    </div>
    <data-list
      :all-data-list="allDataList[0]"
      :total="incomeTotal"
      selected="income"
    />
    <div class="title">
      <h2>月々支出</h2>
    </div>
    <data-list
      :all-data-list="allDataList[1]"
      :total="monthlyPaymentTotal"
      selected="monthly"
    />
    <div class="title">
      <h2>年支出</h2>
    </div>
    <data-list
      :all-data-list="allDataList[2]"
      :total="yearPaymentTotal"
      selected="year"
    />
    <footer>
      <div>
        <select v-model="selected">
          <option
            v-for="option in options"
            :key="option.section"
            :value="option.section"
          >
            {{ option.value }}
          </option>
        </select>

        <input v-model="item" type="text" placeholder="項目" />
        <input v-model="price" type="number" placeholder="金額" />
        <input v-model="remark" type="text" placeholder="備考" />
        <input
          type="submit"
          value="保存"
          :disabled="!formValid"
          @click="store()"
        />
      </div>
    </footer>
  </div>
</template>

<script>
import axios from 'axios'
import DataList from '~/components/DataList.vue'
export default {
  name: 'App',
  component: {
    DataList,
  },
  async asyncData({ $axios }) {
    const allDataList = await $axios.$get('http://localhost:8000/api/getall')
    const incomeTotal = allDataList[0].reduce(function (sum, element) {
      return sum + element.price
    }, 0)
    const monthlyPaymentTotal = allDataList[1].reduce(function (sum, element) {
      return sum + element.price
    }, 0)
    const yearPaymentTotal = allDataList[2].reduce(function (sum, element) {
      return sum + element.price
    }, 0)
    return { allDataList, incomeTotal, monthlyPaymentTotal, yearPaymentTotal }
  },
  data() {
    return {
      // items: ['', '項目', '金額', '備考', '編集'],
      selected: '',
      item: undefined,
      price: undefined,
      remark: undefined,
      options: [
        { section: 1, value: '月々収入' },
        { section: 2, value: '月々支出' },
        { section: 3, value: '年支出' },
      ],
    }
  },
  computed: {
    formValid() {
      return this.selected && this.item && this.price
    },
  },
  methods: {
    async store() {
      const url = 'api/store'
      const data = {
        category_id: this.selected,
        item: this.item,
        price: this.price,
        remark: this.remark,
      }
      await axios.post(url, data)
      this.init()
    },
    init() {
      this.$router.go({
        path: this.$router.currentRoute.path,
        force: true,
      })
    },
  },
}
</script>

<style scoped>
header {
  position: sticky;
  position: -webkit-sticky;
  top: 0;
  background-color: #fff;
  border-bottom: inset 0.1px #111;
}
.container {
  text-align: center;
  max-width: 600px;
  color: red;
  margin: 0 auto;
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

select {
  font-size: 18px;
  padding: 0.2em 0.3em;
  border-radius: 3px;
  border: none;
  background: #efefef;
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

footer {
  position: sticky;
  position: -webkit-sticky;
  bottom: 0;
  background: #333;
  height: 4rem;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
