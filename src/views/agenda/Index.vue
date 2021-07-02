<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div class="agenda">
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
      <v-spacer/>
      <Account/>
    </v-app-bar>

    <v-container class="px-10 pb-10">
      <h1 class="my-2">
        Agenda
      </h1>
      <v-card
        color="#fff"
        elevation="2"
        class="px-0 pa-3"
        style=""

      >
        <v-row dense
               elevation="5">
          <v-col>
            <h3 class=" px-3 font-weight-light">Agenda / Informasi Dinas</h3>
          </v-col>
          <v-col lg="8" align="right">
            <v-btn
              class="mx-2"
              fab
              x-small
              outlined
              @click="_add()"
              style="border-width: 3px"
              color="cyan"
            >
              <v-icon dark large>
                mdi-plus
              </v-icon>
            </v-btn>
          </v-col>
        </v-row>
        <v-divider class="mt-2"/>
        <template>
          <v-row class="mt-n3 px-3">
            <v-col>
              <v-sheet height="54">
                <v-toolbar align="center"
                           flat
                           dense
                >
                  <v-spacer class="ml-16"/>
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

                  <v-spacer/>
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
                        <v-btn value="left" class="text-capitalize" color="primary" @click="type = 'month'">
                          Bulan
                        </v-btn>
                        <v-btn value="center" class="text-capitalize" color="buttons white--text"
                               @click="type = 'week'">
                          Minggu
                        </v-btn>
                        <v-btn value="right" class="text-capitalize" color="buttons white--text" @click="type = 'day'">
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
                      <v-toolbar-title v-html="selectedEvent.name"/>
                      <v-spacer/>
                      <v-btn icon>
                        <v-icon>mdi-heart</v-icon>
                      </v-btn>
                      <v-btn icon>
                        <v-icon>mdi-dots-vertical</v-icon>
                      </v-btn>
                    </v-toolbar>
                    <v-card-text>
                      <span v-html="selectedEvent.details"/>
                    </v-card-text>
                    <v-card-actions>
                      <v-btn
                        text
                        color="secondary"
                        @click="selectedOpen = false"
                      >
                        Cancel
                      </v-btn>
                    </v-card-actions>
                  </v-card>
                </v-menu>
              </v-sheet>
            </v-col>
          </v-row>
        </template>
      </v-card>
    </v-container>
  </div>
</template>

<script>

import Account from "@/components/default/Account";

export default {
  name: 'Home',
  components: {Account},
  data: () => ({
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
    names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party']
  }),

  mounted() {
    this.$refs.calendar.checkChange()
  }
  ,
  methods: {

    viewDay({date}) {
      this.focus = date
      this.type = 'day'
    }
    ,
    _add() {
      this.$router.push({name: 'agenda_add'})
    }
    ,
    profil() {
      this.$router.push({name: 'profil'})
    }
    ,
    getEventColor(event) {
      return event.color
    }
    ,
    setToday() {
      this.focus = ''
    }
    ,
    prev() {
      this.$refs.calendar.prev()
    }
    ,
    next() {
      this.$refs.calendar.next()
    }
    ,
    showEvent({nativeEvent, event}) {
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
    }
    ,
    updateRange({start, end}) {
      const events = []

      const min = new Date(`${start.date}T00:00:00`)
      const max = new Date(`${end.date}T23:59:59`)
      const days = (max.getTime() - min.getTime()) / 86400000
      const eventCount = this.rnd(days, days + 20)

      for (let i = 0; i < eventCount; i++) {
        const allDay = this.rnd(0, 3) === 0
        const firstTimestamp = this.rnd(min.getTime(), max.getTime())
        const first = new Date(firstTimestamp - (firstTimestamp % 900000))
        const secondTimestamp = this.rnd(2, allDay ? 288 : 8) * 900000
        const second = new Date(first.getTime() + secondTimestamp)

        events.push({
          name: this.names[this.rnd(0, this.names.length - 1)],
          start: first,
          end: second,
          color: this.colors[this.rnd(0, this.colors.length - 1)],
          timed: !allDay
        })
      }

      this.events = events
    }
    ,
    rnd(a, b) {
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
