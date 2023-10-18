<template>
  <div>
    <h3>Filters</h3>
    <label for="sort">Sort by Price:</label>
    <select id="sort" v-model="localSortOrder" @change="sortOrderChanged">
      <option value="asc">Low to High</option>
      <option value="desc">High to Low</option>
    </select>
    <label for="category">Filter by Category:</label>
    <select
      id="category"
      v-model="localSelectedCategory"
      @change="selectedCategoryChanged"
    >
      <option value="">All Categories</option>
      <option v-for="category in categories" :key="category.id" :value="category.id">
        {{ category.name }}
      </option>
    </select>
  </div>
</template>

<script>
import axios from "axios";
import { onMounted, ref } from "vue";

export default {
  props: {
    // categories: Array,
    selectedCategory: String,
    sortOrder: String,
  },
  setup(props, { emit }) {
    const localSelectedCategory = ref(props.selectedCategory);
    const localSortOrder = ref(props.sortOrder);
    const categories = ref([]);
    const selectedCategoryChanged = () => {
      emit("updateSelectedCategory", localSelectedCategory.value);
    };

    const sortOrderChanged = () => {
      emit("updateSortOrder", localSortOrder.value);
    };
    // Fetch products and categories here
    const fetchCategories = async () => {
      try {
        const response = axios.get("/api/categories").then((response) => {
          categories.value = response.data;
          console.log(response.data);
        });
      } catch (error) {
        console.error(error);
      }
    };
    onMounted([fetchCategories]);

    return {
      categories,
      localSelectedCategory,
      localSortOrder,
      selectedCategoryChanged,
      sortOrderChanged,
    };
  },
};
</script>
