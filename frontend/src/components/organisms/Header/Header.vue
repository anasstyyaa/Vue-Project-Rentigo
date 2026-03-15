<template>
  <header class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center">
          <Heading :level="1" size="xl" class="text-blue-600">
            <router-link to="/" class="hover:text-blue-700 transition-colors">
              Rentigo
            </router-link>
          </Heading>
        </div>

        <nav class="hidden md:flex items-center space-x-8">
          <router-link
            v-for="link in navigationLinks"
            :key="link.name"
            :to="link.href"
            class="text-gray-700 hover:text-blue-600 transition-colors font-medium"
          >
            {{ link.name }}
          </router-link>

          <div class="border-l pl-8 flex items-center space-x-4">
            <template v-if="user">
              <router-link 
                v-if="isAdmin"
                to="/admin/users" 
                class="flex items-center space-x-2 bg-slate-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-700 transition-all shadow-sm"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>CMS</span>
              </router-link>

              <Text as="span" size="sm" color="muted">
                Welcome, 
                <Text as="span" size="sm" weight="bold" color="default">
                  {{ user.firstName }}
                </Text>
              </Text>
              <button 
                @click="handleLogout" 
                class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-all"
              >
                Logout
              </button>
            </template>
            
            <template v-else>
              <router-link 
                to="/login" 
                class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 shadow-sm transition-all"
              >
                Sign In
              </router-link>
            </template>
          </div>
        </nav>

        <!-- Mobile Version -->
        <div class="md:hidden flex items-center space-x-4">
           <Text v-if="user" as="span" size="xs" color="muted">
            Hi, {{ user.firstName }}
          </Text>
           <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700">
             <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
               <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
             </svg>
           </button>
        </div>
      </div>

      <div v-if="mobileMenuOpen" class="md:hidden pb-4 border-t border-gray-100 mt-2">
        <nav class="flex flex-col space-y-2 pt-2">
          <router-link v-for="link in navigationLinks" :key="link.name" :to="link.href" class="text-gray-700 px-2 py-2">
            {{ link.name }}
          </router-link>
          <hr class="my-2">
          <button v-if="user" @click="handleLogout" class="text-left text-red-600 px-2 py-2 font-medium">Logout</button>
          <router-link v-else to="/login" class="text-blue-600 px-2 py-2 font-medium">Sign In</router-link>
        </nav>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import Heading from "../../atoms/Heading/Heading.vue";
import Text from "../../atoms/Text/Text.vue";

const props = defineProps({
  navigationLinks: {
    type: Array,
    default: () => [
      { name: "Home", href: "/" },
      { name: "My Rentals", href: "/profile" },
    ],
  },
});

const router = useRouter();
const mobileMenuOpen = ref(false);
const user = ref(null);

const isAdmin = computed(() => {
  return user.value && Number(user.value.roleId) === 2;
});

onMounted(() => {
  const savedUser = localStorage.getItem('user');
  if (savedUser) {
    try {
      user.value = JSON.parse(savedUser);
    } catch (e) {
      localStorage.removeItem('user');
    }
  }
});

const handleLogout = () => {
  localStorage.removeItem('user');
  user.value = null;
  router.push('/login');
};
</script>