<template>
  <v-app-bar
    color="white"
    elevation="0"
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
    <v-avatar class="mx-3">
      <img
        src="https://cdn.vuetifyjs.com/images/john.jpg"
        alt="John"
      >
    </v-avatar>
    <div class="mt-5">
      <h4 class="mr-5 light-blue--text accent-4">
        Tri Mueri Sandess
      </h4>
      <p class="mr-5 light-blue--text accent-1">
        Kasubag umum
      </p>
    </div>
    <div class="text-center">
      <v-menu offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            fab
            text
            small
            color="light-blue accent-4"
            v-bind="attrs"
            v-on="on"
          >
            <v-icon
              large
            >
              mdi-chevron-down
            </v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item
            v-for="(item, index) in items"
            :key="index"
          >
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </div>
  </v-app-bar>
</template>

<script>
export default {
  name: 'AppBar'
  data: () => ({
      items: [
        {title: 'Profil'},
        {title: 'Pengaturan'},
        {title: 'Keluar'},
      ],
  ),
}
}
</script>

<style scoped>

</style>
