<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div class="home">
    <v-app-bar
      color="white"
      fixed
      app
      light
    >
      <v-icon
        color="primary"
        class="mr-5"
        @click="$emit('toggle-drawer')"
        v-text="'mdi-menu'"
      />
      <v-spacer />
      <Account />
    </v-app-bar>
    <v-container class="px-10 pb-10">
      <div class="mb-3">
        <h1 class="my-2">
          Dashboard
        </h1>
        <v-row dense>
          <v-col
            class="mr-5"
            cols="12"
            sm="6"
            md="4"
          >
            <v-card
              color="#39D5CF"
              dark
              style="border-radius: 20px"
            >
              <v-card-text class="mb-4">
                <div class="p-5">
                  <v-icon style="font-size: 4rem !important">
                    mdi-content-copy
                  </v-icon>
                  <div class="float-right text-right">
                    <div class="white--text font-weight-bold display-2">
                      {{ suratMasukActive }}
                    </div>
                    <h3 class="white--text">Surat Masuk</h3>
                  </div>
                </div>
              </v-card-text>
              <v-card-actions class="white">
                <v-btn
                  color="primary"
                  block
                  style="text-transform: capitalize !important;"
                  text
                  @click="goToSuratMasuk()"
                >
                  Lihat Selengkapnya
                  <v-spacer />
                  <v-btn
                    fab
                    color="#1BA7A1"
                    x-small
                    elevation="0"
                    @click="goToSuratMasuk()"
                  >
                    <v-icon>
                      mdi-arrow-bottom-left
                    </v-icon>
                  </v-btn>
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
          <v-col
            cols="12"
            sm="6"
            md="4"
          >
            <v-card
              color="#FF007C"
              dark
              style="border-radius: 20px"
            >
              <v-card-text class="mb-4">
                <div class="p-5">
                  <v-icon style="font-size: 4rem !important">
                    mdi-content-copy
                  </v-icon>
                  <div class="float-right text-right">
                    <div class="white--text font-weight-bold display-2">
                      {{ suratKeluarActive }}
                    </div>
                    <h3 class="white--text">Surat Keluar</h3>
                  </div>
                </div>
              </v-card-text>
              <v-card-actions class="white">
                <v-btn
                  color="primary"
                  block
                  style="text-transform: capitalize !important;"
                  text
                  @click="goToSuratKeluar()"
                >
                  Lihat Selengkapnya
                  <v-spacer />
                  <v-btn
                    fab
                    color="#A72D68"
                    x-small
                    elevation="0"
                    @click="goToSuratKeluar()"
                  >
                    <v-icon>
                      mdi-arrow-top-right
                    </v-icon>
                  </v-btn>
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </div>
      <template>
        <v-card
          color="#fff"
          elevation="2"
          class="px-3 pa-3"
          style=""
        >
          <v-row
            dense
            elevation="5"
          >
            <v-col>
              <h3>Agenda / Informasi Dinas</h3>
            </v-col>
          </v-row>
          <v-divider class="mt-2" />
          <v-row class="fill-height">
            <v-col>
              <v-sheet height="54">
                <v-toolbar
                  align="center"
                  flat
                  dense
                >
                  <v-spacer class="ml-16" />
                  <v-btn
                    fab
                    text
                    small
                    color="grey darken-2"
                    @click="prev"
                  >
                    <v-icon small>
                      mdi-chevron-left
                    </v-icon>
                  </v-btn>
                  <v-toolbar-title v-if="$refs.calendar">
                    {{ $refs.calendar.title }}
                  </v-toolbar-title>
                  <v-btn
                    fab
                    text
                    small
                    color="grey darken-2"
                    @click="next"
                  >
                    <v-icon small>
                      mdi-chevron-right
                    </v-icon>
                  </v-btn>

                  <v-spacer />
                  <v-menu
                    bottom
                    right
                  >
                    <template #activator="{ on, attrs }">
                      <v-btn-toggle
                        class="mr-n4"
                        style="border-radius: 20px;"
                        text-color="white"
                        color="grey darken-2"
                        dense
                        v-bind="attrs"
                        v-on="on"
                      >
                        <v-btn
                          value="left"
                          class="text-capitalize"
                          color="primary"
                          @click="type = 'month'"
                        >
                          Bulan
                        </v-btn>
                        <v-btn
                          value="center"
                          class="text-capitalize"
                          color="buttons white--text"
                          @click="type = 'week'"
                        >
                          Minggu
                        </v-btn>
                        <v-btn
                          value="right"
                          class="text-capitalize"
                          color="buttons white--text"
                          @click="type = 'day'"
                        >
                          Hari
                        </v-btn>
                      </v-btn-toggle>
                    </template>
                  </v-menu>
                </v-toolbar>
              </v-sheet>
              <v-sheet height="600">
                <v-calendar
                  ref="calendar"
                  v-model="focus"
                  color="primary"
                  :events="events"
                  :event-color="getEventColor"
                  :type="type"
                  @click:event="showEvent"
                  @click:more="viewDay"
                  @click:date="viewDay"
                  @change="updateRange"
                />
                <v-menu
                  v-model="selectedOpen"
                  :close-on-content-click="false"
                  :activator="selectedElement"
                  offset-x
                >
                  <v-card
                    color="grey lighten-4"
                    min-width="350px"
                    flat
                  >
                    <v-toolbar
                      :color="selectedEvent.color"
                      dark
                    >
                      <v-btn icon>
                        <v-icon>mdi-pencil</v-icon>
                      </v-btn>
                      <v-toolbar-title v-html="selectedEvent.name" />
                      <v-spacer />
                      <v-btn icon>
                        <v-icon>mdi-heart</v-icon>
                      </v-btn>
                      <v-btn icon>
                        <v-icon>mdi-dots-vertical</v-icon>
                      </v-btn>
                    </v-toolbar>
                    <v-card-text>
                      <span v-html="selectedEvent.details" />
                    </v-card-text>
                    <v-card-actions>
                      <v-btn
                        text
                        color="secondary"
                        @click="selectedOpen = false"
                      >
                        Tutup
                      </v-btn>
                    </v-card-actions>
                  </v-card>
                </v-menu>
              </v-sheet>
            </v-col>
          </v-row>
        </v-card>
      </template>
    </v-container>
  </div>
</template>

<script>
import Account from '@/components/default/Account'
import { mapActions } from 'vuex'
export default {
  name: 'Home',
  components: { Account },
  data: () => ({
    datas: [],
    suratKeluarActive: '-',
    suratMasukActive: '-',
    focus: '',
    type: 'month',
    typeToLabel: {
      month: 'Month',
      week: 'Week',
      day: 'Day',
      '4day': '4 Days'
    },
    selectedEvent: {},
    selectedElement: null,
    selectedOpen: false,
    events: [],
    colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
    // names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party']
  }),
  mounted () {
    this.$refs.calendar.checkChange()
  },
  methods: {
    ...mapActions(['getAgendaToCalender']),
    goToSuratMasuk () {
      this.$router.push({ name: 'surat_masuk' })
    },
    goToSuratKeluar () {
      this.$router.push({ name: 'surat_keluar' })
    },
    viewDay ({ date }) {
      this.focus = date
      this.type = 'day'
    },
    getEventColor (event) {
      return event.color
    },
    setToday () {
      this.focus = ''
    },
    prev () {
      this.$refs.calendar.prev()
    },
    next () {
      this.$refs.calendar.next()
    },
    showEvent ({ nativeEvent, event }) {
      const open = () => {
        this.selectedEvent = event
        this.selectedElement = nativeEvent.target
        requestAnimationFrame(() => requestAnimationFrame(() => this.selectedOpen = true))
      }

      if (this.selectedOpen) {
        this.selectedOpen = false
        requestAnimationFrame(() => requestAnimationFrame(() => open()))
      } else {
        open()
      }

      nativeEvent.stopPropagation()
    },
    updateRange ({ start, end }) {
      console.log(`${start.date}  akhir  ${end.date}`)
      this.getAgendaToCalender().then((data) => {
        console.log('ambil lagi')
        this.datas = data.items
        this.suratKeluarActive = data.suratKeluarActive
        this.suratMasukActive = data.suratMasukActive

        const events = []

        // const min = new Date(`${start.date}T00:00:00`)
        // const max = new Date(`${end.date}T23:59:59`)
        // const days = (max.getTime() - min.getTime()) / 86400000
        // const eventCount = this.rnd(days, days + 20)

        for (let i = 0; i < this.datas.length; i++) {
          const allDay = this.rnd(0, 3) === 0
          // const firstTimestamp = this.rnd(min.getTime(), max.getTime())
          // const first = new Date(firstTimestamp - (firstTimestamp % 900000))
          // const secondTimestamp = this.rnd(2, allDay ? 288 : 8) * 900000
          // const second = new Date(first.getTime() + secondTimestamp)
          events.push({
            name: this.datas[i].nama_kegiatan,
            details: this.datas[i].deskripsi_kegiatan,
            start: this.datas[i].waktu_mulai,
            end: this.datas[i].waktu_akhir,
            color: this.datas[i].color,
            timed: !allDay
          })
        }

        this.events = events
      })
    },
    rnd (a, b) {
      return Math.floor((b - a + 1) * Math.random()) + a
    }
  }
}
</script>
<style scoped>
.lead {
  font-size: 12pt !important;
  color: #6c6b6b;
}
</style>
