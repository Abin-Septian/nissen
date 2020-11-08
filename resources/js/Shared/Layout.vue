<template>
  <div>
    <portal-target name="dropdown" slim />
    <div class="flex flex-col">
      <div class="h-screen flex flex-col" @click="hideDropdownMenus">
        <div class="md:flex flex-shrink-0">
          <div class="bg-white md:flex-shrink-0 md:w-56 px-6 flex items-center justify-between md:justify-center">
            <inertia-link class="mt-1" href="/">
              <img class="block w-30 l-30" src="../../../storage/app/users/n1bBG54O1vlr3S6xpeDaMClFI8IerB8AIaIepswA.png">
            </inertia-link>
            <dropdown class="md:hidden" placement="bottom-end">
              <svg class="fill-white w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
              <div slot="dropdown" class="mt-2 px-8 py-4 shadow-lg bg-indigo-800 rounded">
                <main-menu-small :url="url()" />
              </div>
            </dropdown>
          </div>
          <div class="bg-white border-b w-full p-4 md:py-0 md:px-12 text-sm md:text-md flex justify-between items-center">
            <div class="mt-1 mr-4 text-xl2 font-bold">Sistem Dokumentasi Training</div>
            <dropdown class="mt-1" placement="bottom-end">
              <div class="flex items-center cursor-pointer select-none group">
                <div class="text-gray-700 group-hover:text-indigo-600 focus:text-indigo-600 mr-1 whitespace-no-wrap">
                  <span>{{ $page.auth.user.first_name }}</span>
                  <span class="hidden md:inline">{{ $page.auth.user.last_name }}</span>
                </div>
                <icon class="w-5 h-5 group-hover:fill-indigo-600 fill-gray-700 focus:fill-indigo-600" name="cheveron-down" />
              </div>
              <div slot="dropdown" class="mt-2 py-2 shadow-xl bg-white rounded text-sm">
                <inertia-link v-if="owner == true" class="block px-6 py-2 hover:bg-indigo-500 hover:text-white" :href="route('users.edit', $page.auth.user.id)">My Profile</inertia-link>
                <inertia-link v-if="owner == true" class="block px-6 py-2 hover:bg-indigo-500 hover:text-white" :href="route('users')">Manage Users</inertia-link>
                <inertia-link class="block px-6 py-2 hover:bg-indigo-500 hover:text-white" :href="route('logout')" method="post">Logout</inertia-link>
              </div>
            </dropdown>
          </div>
        </div>
        <div class="flex flex-grow overflow-hidden">
          <main-menu :url="url()" class="bg-indigo-800 flex-shrink-0 w-56 p-3 hidden md:block overflow-y-auto" />
          <div class="flex-1 px-4 py-8 md:p-6 overflow-y-auto" scroll-region>
            <flash-messages />
            <slot />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Dropdown from '@/Shared/Dropdown'
import FlashMessages from '@/Shared/FlashMessages'
import Icon from '@/Shared/Icon'
import MainMenu from '@/Shared/MainMenu'
import MainMenuSmall from '@/Shared/MainMenuSmall'

export default {
  components: {
    Dropdown,
    FlashMessages,
    Icon,
    MainMenu,
    MainMenuSmall,
  },
  data() {
    return {
      showUserMenu: false,
      accounts: null,
      owner: this.$parent.$data.props.auth.user.role,
      department_id: this.$parent.$data.props.auth.user.department_id,
      logo: 'http://localhost:8008/img/users/n1bBG54O1vlr3S6xpeDaMClFI8IerB8AIaIepswA.png/2f5e5877ed5247a49def5d410a7c31d6a8dc428ea83b534faeaf8edd95640caf/n1bBG54O1vlr3S6xpeDaMClFI8IerB8AIaIepswA.jpg?w=100&h=100&fit=crop',
    }
  },
  methods: {
    url() {
      return location.pathname.substr(1)
    },
    hideDropdownMenus() {
      this.showUserMenu = false
    },
  },
}
</script>
