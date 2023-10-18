<template>
  <div>
    <h2>Category List</h2>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Category</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="category in categories" :key="category.id">
          <td>{{ category.id }}</td>
          <td>{{ category.name }}</td>
          <td>
            <span v-if="category.parent"> {{ category.parent.name }} </span>
          </td>
          <td>
            <div class="row gap-3">
              <!-- <router-link :to="`/categories/${category.id}`"
                                class="p-2 col border btn btn-primary">View</router-link> -->
              <router-link
                :to="'/category-edit/' + category.id"
                class="p-2 col border btn btn-success"
                >Edit</router-link
              >
              <button
                @click="deleteCategory(category.id)"
                class="p-2 col border btn btn-danger"
              >
                Delete
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  setup() {
    const categories = ref([]);

    const fetchCategories = async () => {
      try {
        const response = await axios.get("/api/categories");
        categories.value = response.data;
        console.log(categories.value);
      } catch (error) {
        console.error(error);
      }
    };

    const deleteCategory = async (id) => {
      try {
        await axios.delete(`/api/categories/${id}`);
        categories.value = categories.value.filter((category) => category.id !== id);
      } catch (error) {
        console.error(error);
      }
    };

    onMounted(fetchCategories);

    return {
      categories,
      deleteCategory,
    };
  },
};
</script>
