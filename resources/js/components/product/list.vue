<template>
  <div>
    <h2>Product List</h2>

    <div>
      <div class="row">
        <div class="col-md-6">
          <label for="sort" class="form-label">Sort by Price:</label>
          <select
            id="sort"
            class="form-control"
            v-model="sortOrder"
            @change="fetchProducts()"
          >
            <option value="asc">Low to High</option>
            <option value="desc">High to Low</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="category" class="form-label">Filter by Category:</label>
          <select
            id="category"
            class="form-control"
            v-model="selectedCategory"
            @change="fetchProducts()"
          >
            <option value="">All Categories</option>
            <option
              v-for="category in categories"
              :key="category.id"
              :value="category.id"
            >
              {{ category.name }}
            </option>
          </select>
        </div>
      </div>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Description</th>
          <th scope="col">Price</th>
          <th scope="col">Image</th>
          <th scope="col">Category</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.id }}</td>
          <td>{{ product.name }}</td>
          <td>{{ product.description }}</td>
          <td>{{ product.price }}</td>
          <td>
            <img
              :src="getImageUrl(product.image)"
              :alt="product.name + ' Image'"
              class="product-image"
            />
          </td>
          <td>{{ product.category.name }}</td>
          <td>
            <div class="row gap-3">
              <!-- <router-link :to="`/products/${product.id}`"
                                class="p-2 col border btn btn-primary">View</router-link> -->
              <router-link
                :to="'/product-edit/' + product.id"
                class="p-2 col border btn btn-success"
                >Edit</router-link
              >
              <button
                @click="deleteProduct(product.id)"
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
import { ref, onMounted, watch } from "vue";
import axios from "axios";

export default {
  setup() {
    const products = ref([]);
    const categories = ref([]);
    const selectedCategory = ref("");
    const sortOrder = ref("asc");

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

    const fetchProducts = async () => {
      try {
        const response = await axios.get(
          "/api/products" +
            "?sortBy=" +
            sortOrder.value +
            "&category_id=" +
            selectedCategory.value
        );
        products.value = response.data;
      } catch (error) {
        console.error(error);
      }
    };

    const deleteProduct = async (id) => {
      try {
        await axios.delete(`/api/products/${id}`);
        products.value = products.value.filter((product) => product.id !== id);
      } catch (error) {
        console.error(error);
      }
    };

    const getImageUrl = (imagePath) => {
      if (imagePath) {
        return `${window.assetUrl}storage/${imagePath}`;
      } else {
        return null;
      }
    };

    onMounted([fetchProducts, fetchCategories]);

    return {
      products,
      categories,
      selectedCategory,
      sortOrder,
      deleteProduct,
      getImageUrl,
      fetchProducts,
    };
  },
};
</script>

<style scoped>
.product-image {
  max-width: 100px;
  max-height: 100px;
}
</style>
