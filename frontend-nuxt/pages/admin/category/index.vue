<template>
  <div
    class="container px-4 mx-auto flex-wrap justify-between min-h-screen relative"
  >
    <breadcrumb :breadcrumbs="breadcrumbs" class="pb-4"></breadcrumb>
    <div class="inline-flex w-full justify-between">
      <h3 class="font-bold pb-4 text-4xl xs:text-2xl text-indigo-500">
        Kelola Kategori Campaign
      </h3>
      <div>
        <button
          class="px-4 py-2 rounded text-white shadow-lg bg-indigo-500 hover:bg-indigo-600 focus:bg-indigo-700 font-bold"
          @click="showModal(null, 'add')"
        >
          <span class="inline-flex items-center p-0 m-0">
            <svg
              class="w-5 h-5 -ml-1 mr-1"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
            Tambah Kategori
          </span>
        </button>
      </div>
    </div>

    <div>
      <div class="relative overflow-auto pb-20">
        <table class="relative table-auto w-full text-left whitespace-no-wrap">
          <thead>
            <tr>
              <th
                class="px-4 py-3 title-font tracking-wider font-medium text-gray-600 text-sm bg-gray-100 rounded-tl rounded-bl"
              >
                Nama Kategori
              </th>
              <th
                class="px-4 py-3 title-font tracking-wider font-medium text-gray-600 text-sm bg-gray-100 rounded-tl rounded-bl"
              >
                Aksi
              </th>
            </tr>
          </thead>
          <tbody class="bg-white relative text-sm">
            <tr
              v-for="category in categories"
              :key="category.id"
              class="hover:bg-gray-100 relative"
            >
              <td
                class="border-t-2 border-gray-200 px-4 py-3"
                style="max-width: 200px"
              >
                {{ category.categories }}
              </td>
              <td
                class="border-t-2 border-gray-200 px-4 py-3"
                style="max-width: 200px"
              >
                <button
                  class="px-2 py-1 bg-yellow-500 text-sm text-white hover:bg-yellow-600 focus:outline-none text-center rounded-lg mr-2 shadow-md"
                  @click="showModal(category, 'edit')"
                >
                  Edit
                </button>
                <button
                  class="px-2 py-1 bg-red-500 text-sm text-white hover:bg-red-600 focus:outline-none text-center rounded-lg mr-2 shadow-md"
                >
                  Hapus
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <ManageCategory
        :status="showModalStatus"
        @clicked="showModal(null, 'close')"
        :todo="todo"
        :categorySelected="categorySelected"
        :idSelected="idSelected"
      />
    </div>
  </div>
</template>
<script>
import EmailTable from '@/components/DataTables/EmailTable'
import Breadcrumb from '@/components/Breadcrumb'
import ManageCategory from '@/components/Modal/ManageCategory'

export default {
  components: { EmailTable, Breadcrumb, ManageCategory },
  data() {
    return {
      breadcrumbs: [],
      showModalStatus: false,
      categorySelected: '',
      idSelected: null,
      todo: 'edit',
      categories: [],
    }
  },

  mounted() {
    const fullPath = this.$route.fullPath
    const params = fullPath.substring(1).split('/')

    let path = ''
    let crumbs = []

    params.forEach((param, index) => {
      path = `${path}/${param}`
      const match = this.$router.match(path)

      //   Jika name route tidak null dan name route belum ada di crumbs
      if (
        match.name !== null &&
        crumbs.map((val) => val.name).indexOf(match.name) === -1
      ) {
        crumbs.push(match)
      }
    })
    this.breadcrumbs = crumbs

    this.$nextTick(() => {
      this.$nuxt.$loading.start()
    })

    this.$axios
      .$get('campaign/categories')
      .then((resp) => {
        this.categories = resp.categories
      })
      .catch((errors) => {
        console.log(errors)
      })
  },

  methods: {
    showModal(data, status) {
      // console.log(data)
      if (data !== null) {
        this.categorySelected = data.categories
        this.idSelected = data.id
      } else {
        this.categorySelected = ''
      }
      this.todo = status
      this.showModalStatus = !this.showModalStatus
    },
  },
}
</script>
