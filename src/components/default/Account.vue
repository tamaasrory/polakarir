<template>
  <div color="white"
       elevation="0"
       fixed
       app
       light>
    <div class="mt-4">
      <v-row>
        <div name="akun" class="mx-4">
          <v-badge
              color="#FF6969"
              bottom
              left
              content="6"
              bordered
              style="border-radius: 5px"
              overlap
          >
            <v-icon large
                    class="mt-1"
            >mdi-bell-outline
            </v-icon>
          </v-badge>
        </div>

        <v-avatar class="mx-3">
          <img
              src="https://cdn.vuetifyjs.com/images/john.jpg"
              alt="John"
          >
        </v-avatar>
        <div>
          <h4 class="mr-5 primary--text">
            Tri Mueri Sandes
          </h4>
          <p class="mr-5 primary--text accent-1 font-weight-light">
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
              <v-list-item>
                <v-list-item-title
                    style="cursor: pointer" @click="profil">Profile
                </v-list-item-title>
              </v-list-item>
              <v-list-item>
                <v-list-item-title style="cursor: pointer">Logout</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </div>
      </v-row>

    </div>

  </div>
</template>

<script>
export default {
  name: "Account",
  methods: {
    profil() {
      this.$router.push({name: 'profil'})
    }
  },
  components: {

    //  'accounts': accounts,
  }
}
</script>

<style scoped>

</style>
