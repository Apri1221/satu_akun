<template>
  <div class="relative container px-4 mx-auto min-h-screen">
    <div class="relative w-full h-screen">
      <h3 class="font-bold pb-3 text-4xl xs:text-2xl text-indigo-500">
        Daftar Campaign
      </h3>

      <div
        class="relative w-full overflow-visible xs:overflow-x-auto xs:overflow-y-visible h-full"
      >
        <div v-if="campaigns === null">
          <Spinner />
        </div>
        <table
          v-else
          class="relative table-auto w-full text-left whitespace-no-wrap h-auto"
        >
          <thead>
            <tr>
              <th
                class="px-4 py-3 title-font tracking-wider font-medium text-gray-600 text-sm bg-gray-100 rounded-tl rounded-bl"
              >
                Nama Campaign
              </th>
              <th
                class="px-4 py-3 title-font tracking-wider font-medium text-gray-600 text-sm bg-gray-100"
              >
                Anggota
              </th>

              <th
                class="px-4 py-3 title-font tracking-wider font-medium text-gray-600 text-sm bg-gray-100"
              >
                Dana Terkumpul
              </th>
              <th
                class="px-4 py-3 title-font tracking-wider font-medium text-gray-600 text-sm bg-gray-100"
              >
                Status
              </th>

              <th
                class="w-10 title-font tracking-wider text-gray-600 text-sm bg-gray-100 rounded-tr rounded-br"
              ></th>
            </tr>
          </thead>

          <tbody class="bg-white relative text-sm">
            <tr
              v-for="(campaign, index) in campaigns"
              :key="campaign.id"
              class="hover:bg-gray-100 relative"
            >
              <td
                class="border-t-2 border-gray-200 px-4 py-3"
                style="max-width: 200px"
              >
                <p class="text-sm leading-5 text-gray-800 font-medium truncate">
                  {{ campaign.title }}
                </p>
              </td>
              <td class="border-t-2 border-gray-200 px-4 py-3">
                <div class="text-sm leading-5">
                  {{ campaign.slot_members }}/{{ campaign.slot_capacity }}
                </div>
              </td>

              <td class="border-t-2 border-gray-200 px-4 py-3">
                {{ campaign.slot_price | formatRupiah }}
              </td>
              <td class="border-t-2 border-gray-200 px-4 py-3 text-xs">
                <span
                  class="relative h-full px-3 py-1 font-semibold text-green-900 leading-tight text-center inline-block"
                >
                  <span
                    aria-hidden
                    class="bg-yellow-500 rounded-full text-xs font-bold capitalize text-white m-0 px-2 py-1"
                    v-if="campaign.status === 0"
                    >Aktif</span
                  >
                  <span
                    aria-hidden
                    class="bg-indigo-500 rounded-full text-xs font-bold capitalize text-white m-0 px-2 py-1"
                    v-if="campaign.status === 1"
                    >Berlangsung</span
                  >
                  <span
                    aria-hidden
                    class="bg-gray-600 rounded-full text-xs font-bold capitalize text-white m-0 px-2 py-1"
                    v-if="campaign.status === 2"
                    >Expired</span
                  >
                  <span
                    aria-hidden
                    class="bg-red-600 rounded-full text-xs font-bold capitalize text-white m-0 px-2 py-1"
                    v-if="campaign.status === 3"
                    >Refund</span
                  >
                  <span
                    aria-hidden
                    class="bg-red-300 rounded-full text-xs font-bold capitalize text-white m-0 px-2 py-1"
                    v-if="campaign.status === 4"
                    >Selesai Refund</span
                  >
                  <span
                    aria-hidden
                    class="bg-green-400 rounded-full text-xs font-bold capitalize text-white m-0 px-2 py-1"
                    v-if="campaign.status === 5"
                    >Selesai</span
                  >
                </span>
              </td>
              <td class="border-t-2 border-gray-200 px-4 py-3">
                <div
                  class="group inline-block relative"
                  v-click-outside
                  @clicked-outside="showDetail()"
                >
                  <button
                    class="items-center px-2 py-1 border bg-white text-indigo-500 rounded transition duration-300 focus:outline-none flex font-semibold"
                    @click="showDetail(index)"
                    :disabled="campaign.status == '3' || campaign.status == '2'"
                    :class="{
                      'disabled:opacity-50 bg-gray-300 border-gray-500':
                        campaign.status == '2' || campaign.status == '3',
                      'border-indigo-400 hover:border-indigo-700':
                        campaign.status != '2' || campaign.status == '3',
                    }"
                  >
                    Detail

                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      class="h-4 w-4 ml-3 z-0"
                      :class="{
                        'transform rotate-180 transition duration-500 ease-in-out':
                          activeDetail == index,
                        'transform rotate-0 transition duration-500 ease-in-out':
                          activeDetail != index,
                      }"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                      />
                    </svg>
                  </button>
                  <ul
                    class="shadow-md bg-white text-gray-800 cursor-pointer rounded transform absolute divide-y transition duration-300 ease-in-out mt-1 origin-left z-10 right-0 min-w-auto"
                    :class="{
                      '': activeDetail == index,
                      hidden: activeDetail != index,
                    }"
                  >
                    <li class="px-2 py-2 hover:bg-gray-100 w-full border-none">
                      <a
                        class="inline-flex items-center"
                        :href="`/users/${getIdUser}/campaign/${campaign.id}`"
                      >
                        <svg
                          class="w-4 h-4 mr-2"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                          />
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                          />
                        </svg>
                        <span class="text-sm"> Detail Campaign </span>
                      </a>
                    </li>
                    <li class="px-2 py-2 hover:bg-gray-100 w-full border-none">
                      <a
                        class="inline-flex items-center"
                        href="https://wa.me/628976634788?text=Saya%20ingin%20melaporkan%20campaign%20dengan%20ID:%20ID_Campaign"
                        target="_blank"
                        ref="non"
                      >
                        <svg
                          class="w-4 h-4 mr-2"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="red"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                          />
                        </svg>
                        <span class="text-sm"> Laporkan </span>
                      </a>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
import moment from 'moment'
export default {
  layout: 'default',

  data() {
    return {
      activeDetail: null,
      detail: false,
      campaigns: null,
    }
  },
  methods: {
    showDetail(value) {
      if (value === this.activeDetail) {
        this.activeDetail = null
      } else {
        this.activeDetail = value
      }
    },
  },
  watch: {
    $route(to, from) {
      this.showDetail()
    },
  },
  activated() {
    if (this.$fetchState.timestamp <= Date.now() - 30000) {
      this.$fetch()
    }
  },
  //   https://id.nuxtjs.org/docs/2.x/features/data-fetching/#menggunakan-pengait-activated
  fetch() {
    this.$axios
      .$get(`campaign/user/${this.$store.state.user.id}?host=true`)
      .then((resp) => {
        console.log(resp)
        this.campaigns = resp.campaigns
        console.log(this.campaigns)
      })
      .catch((errors) => {
        console.log(errors)
      })
  },
  computed: {
    getIdUser() {
      return this.$store.state.user.id
    },
  },
}
</script>
