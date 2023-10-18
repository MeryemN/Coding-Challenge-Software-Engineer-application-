<template>
  <div>
    <h2>Edit Category</h2>
    <form @submit.prevent="updateCategory" class="row">
      <div class="mb-3 col-md-6">
        <label for="name" class="form-label text-primary">Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          v-model="category.name"
          required
        />
      </div>

      <div class="mb-3 col-md-6">
        <label for="category" class="form-label text-primary">Parent Category</label>
        <select class="form-select" id="category" v-model="selectedParent">
          <option value="">Select a category</option>
          <option
            v-for="parentCategory in categories"
            :key="parentCategory.id"
            :value="parentCategory.id"
          >
            {{ parentCategory.name }}
          </option>
        </select>
      </div>
      <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Update Category</button>
      </div>
    </form>
  </div>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

axios.defaults.headers.common["X-CSRF-TOKEN"] = document
  .querySelector('meta[name="csrf-token"]')
  .getAttribute("content");

export default {
  setup() {
    const category = ref({
      id: null,
      name: "",
      // parent: { id: null },
      parent_id: null, // Change to 'parent_id'
    });

    const categories = ref([]);
    const router = useRouter();

    const fetchCategory = async () => {
      try {
        category.value = (
          await axios.get(`/api/categories/${router.currentRoute.value.params.id}/edit`)
        ).data;
      } catch (error) {
        console.error(error);
      }
    };

    const fetchCategories = async () => {
      try {
        categories.value = (await axios.get("/api/categories")).data;
      } catch (error) {
        console.error(error);
      }
    };

    const updateCategory = async () => {
      try {
        const formData = new FormData();
        formData.append("name", category.value.name);
        formData.append("parent_id", category.value.parent_id); // Use 'parent_id'

        await axios.post(`/api/category-update/${category.value.id}`, formData);

        router.push({ name: "category-list" });
      } catch (error) {
        console.error(error);
      }
    };

    // Define a computed property to handle a null parent_id
    const selectedParent = computed({
      get: () => category.value.parent_id || "", // Use an empty string as a default value
      set: (value) => {
        category.value.parent_id = value;
      },
    });

    onMounted(() => {
      fetchCategory();
      fetchCategories();
    });

    return {
      category,
      categories,
      updateCategory,
      selectedParent,
    };
  },
};
</script>
