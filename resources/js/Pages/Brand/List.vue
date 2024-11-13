<script setup>
import { ref, watch } from 'vue';
import { Button } from '@/components/ui/button'
import Input from '@/components/ui/input/Input.vue';
import { router,Link } from '@inertiajs/vue3';

const props = defineProps({
  brands: Object,
  brandCount: Number,
  active_letter: String,
  search: String,

});

const letters = [...Array(26)].map((_, i) => String.fromCharCode(65 + i)); // ['A', 'B', 'C', ..., 'Z']
const activeLetter = ref(props.active_letter); // Active letter to track the selected button
const search = ref(props.search); // Active letter to track the selected button

const loadData = () => {
  router.get(route('brand.list'), { active_letter: activeLetter.value, search: search.value }, { preserveState: true, preserveScroll: true });
}

watch([search, activeLetter], ([newSearch, newPerPage], [oldSearch, oldPerPage]) => {
  loadData()
});

</script>

<template>
  <main class="flex flex-1 flex-col gap-4 p-4 lg:gap-6 lg:p-6">
    <div class="mt-6 flex items-center justify-between space-x-4">
      <div class="mt-6 space-y-1">
        <h2 class="text-2xl font-semibold tracking-tight">
          Brands
        </h2>
        <p class="text-sm text-muted-foreground">
          (Showing {{ brandCount }} results)
        </p>
        <Link :href="route('dashboard')">
        <Button>Back</Button>
        </Link>
      </div>
      <div class="mt-6 space-y-1">
        <Input class="max-w-sm" placeholder="Search..." v-model="search" />
      </div>
    </div>

    <div class="flex flex-wrap justify-center gap-4">

      <Button :variant="activeLetter == letter ? '' : 'secondary'" v-for="letter in letters" :key="letter"
        @click="activeLetter == letter ? activeLetter = '' : activeLetter = letter">{{ letter
        }}</Button>
      <Button :variant="activeLetter == '#' ? '' : 'secondary'"
        @click="activeLetter == '#' ? activeLetter = '' : activeLetter = '#'">#</Button>

    </div>

    <div class="relative" v-if="brands.length">
      <div class="flex flex-wrap justify-center gap-4">
        <div class="overflow-hidden rounded-md" v-for="brand in brands">
          <img :src="brand.logo" class="h-[200px]  object-cover transition-all hover:scale-105" />
        </div>
      </div>
    </div>

    <div class="flex flex-1 items-center justify-center rounded-lg border border-dashed shadow-sm" v-else>
      <div class="flex flex-col items-center gap-1 text-center">
        <h3 class="text-2xl font-bold tracking-tight">
          Brands not found !
        </h3>
      </div>
    </div>
  </main>
</template>