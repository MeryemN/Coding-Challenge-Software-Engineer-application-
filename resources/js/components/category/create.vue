<template>
  <div>
    <h2>Create Category</h2>
    <form @submit="createCategory" class="row">
      <div class="mb-3 col-md-6">
        <label for="name" class="form-label text-primary">Category Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          v-model="category.name"
          required
        />
      </div>
      <div class="mb-3 col-md-6">
        <label for="parentCategory" class="form-label text-primary"
          >Parent Category</label
        >
        <select class="form-select" id="parentCategory" v-model="category.parent_id">
          <option value="">Select a parent category</option>
          <option
            v-for="parentCategory in parentCategories"
            :key="parentCategory.id"
            :value="parentCategory.id"
          >
            {{ parentCategory.name }}
          </option>
        </select>
      </div>
      <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Create Category</button>
      </div>
    </form>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

export default {
  setup() {
    const category = ref({
      name: "",
      parent_id: null, // Initialize to null
    });

    const parentCategories = ref([]);
    const router = useRouter();

    // Fetch parent categories
    const fetchParentCategories = async () => {
      try {
        const response = await axios.get("/api/categories");
        parentCategories.value = response.data;
      } catch (error) {
        console.error(error);
      }
    };

    const createCategory = async () => {
      try {
        const response = await axios.post("/api/categories", category.value);

        if (response.status === 201) {
          router.push({ name: "category-list" });
        } else {
          console.error("Category creation failed.");
        }
      } catch (error) {
        console.error(error);
      }
    };

    onMounted(() => {
      fetchParentCategories();
    });

    return {
      category,
      parentCategories,
      createCategory,
    };
  },
};
</script>
