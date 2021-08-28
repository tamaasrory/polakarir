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
      </div>
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
    queryTask: [],
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
    options: {},
    selectedEvent: {},
    selectedElement: null,
    selectedOpen: false,
    events: []
    // colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
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
      this.options.from = `${start.date}`
      this.options.to = `${end.date}`
      this.getAgendaToCalender({ add: this.queryTask, ...this.options }).then((data) => {
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
