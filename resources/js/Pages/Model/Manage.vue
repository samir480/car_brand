<script setup>
import Layout from '@/Layout/Layout.vue';
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {
  ChevronLeft,
} from 'lucide-vue-next'
import { Link, useForm, router } from '@inertiajs/vue3';
import { ref } from "vue";
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
const props = defineProps({
  model: Object,
  brands: Object,
  errors: Object,
});


const form = useForm({
  name: null,
  image: null,
  year: null,
  brand_id: null,
});

const imagePreview = ref(props.model ? props.model.image : null);
const handleFileChange = (event) => {
  const file = event.target.files[0];
  form.image = file;

  // Create a preview for the selected image
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target.result; // Set the preview URL
    };
    reader.readAsDataURL(file); // Read the file to create a base64 preview
  } else {
    imagePreview.value = null; // Clear the preview if no file is selected
  }
}
// create and edit logic
if (props.model) {
  form.name = props.model.name;
  form.year = props.model.year;
  form.brand_id = String(props.model.brand_id);
}

const submit = () => {
  if (props.model)
    form._method = 'put',
      router.post(route("model.update", props.model.id), form, {
        onError: (error) => {
          form.errors = error;
        },
      });
  else
    form.post(route("model.store"), form, {
      onError: (error) => {
        form.errors = error;
      },
    });
};

</script>

<template>
  <Layout>
    <div class=" grid  flex-1 auto-rows-max gap-4">
      <div class="flex items-center gap-4">
        <Link :href="route('model.index')">
        <Button variant="outline" size="icon" class="h-7 w-7">
          <ChevronLeft class="h-4 w-4" />
          <span class="sr-only">Back</span>
        </Button>
        </Link>
        <h1 class="flex-1 shrink-0 whitespace-nowrap text-xl font-semibold tracking-tight sm:grow-0">
          Models
        </h1>
      </div>
      <div class="grid gap-4 lg:gap-8">
        <div class="grid auto-rows-max items-start gap-4 lg:col-span-2 lg:gap-8">
          <Card>
            <CardHeader>
              <CardTitle>New Model</CardTitle>
            </CardHeader>
            <CardContent>
              <form @submit.prevent="submit" class="grid gap-6">

                <div class="grid gap-3">
                  <Label for="name">Brand</Label>
                  <Select v-model="form.brand_id">
                    <SelectTrigger class="w-full">
                      <SelectValue placeholder="Select a Brand" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectGroup>
                        <SelectLabel>Select Brand</SelectLabel>
                        <SelectItem v-for="brand in brands" :value="String(brand.id)">
                          {{ brand.name }}
                        </SelectItem>
                      </SelectGroup>
                    </SelectContent>
                  </Select>
                  <span v-if="form.errors.brand_id" class="text-red-500 text-sm">{{ form.errors.brand_id }}</span>
                </div>

                <div class="grid gap-3">
                  <Label for="name">Name</Label>
                  <Input v-model="form.name" id="name" type="text" class="w-full" placeholder="Enter Model name" />
                  <span v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</span>
                </div>

                <div class="grid gap-3">
                  <Label for="year">Manufacturing year</Label>
                  <Input v-model="form.year" id="year" type="number" class="w-full"
                    placeholder="Enter manufacturing year" />
                  <span v-if="form.errors.year" class="text-red-500 text-sm">{{ form.errors.year }}</span>
                </div>

                <div class="grid gap-3">
                  <Label for="logo">Image</Label>
                  <Input id="logo" type="file" @input="handleFileChange($event)" />
                  <span v-if="form.errors.image" class="text-red-500 text-sm">{{ form.errors.image }}</span>
                  <img :src="imagePreview" v-if="imagePreview"
                    class="h-2/3 w-1/3 object-cover transition-all hover:scale-105" />
                </div>


                <div class=" items-center gap-2 ml-auto flex">
                  <Link :href="route('model.index')">
                  <Button variant="outline" size="sm" type="button">
                    Discard
                  </Button>
                  </Link>
                  <Button size="sm" type="submit">
                    Save Model
                  </Button>
                </div>
              </form>
            </CardContent>
          </Card>
        </div>
      </div>
    </div>
  </Layout>
</template>