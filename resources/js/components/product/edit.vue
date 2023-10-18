<template>
  <div>
    <h2>Edit Product</h2>
    <form @submit.prevent="updateProduct">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          v-model="product.name"
          required
        />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea
          class="form-control"
          id="description"
          v-model="product.description"
        ></textarea>
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input
          type="number"
          class="form-control"
          id="price"
          v-model="product.price"
          required
        />
      </div>
      <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select class="form-select" id="category" v-model="product.category_id">
          <option value="">Select a category</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" id="image" @change="handleImageUpload" />
      </div>
      <div class="mb-3">
        <img
          :src="getImageUrl(product.image)"
          alt="Product Image"
          style="max-width: 100px; max-height: 100px"
        />
      </div>
      <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
  .querySelector('meta[name="csrf-token"]')
  .getAttribute("content");

export default {
  setup() {
    const product = ref({
      id: null,
      name: "",
      description: "",
      price: null,
      category_id: null,
      image: null,
    });

    const categories = ref([]);
    const router = useRouter();

    // Fetch product data
    const fetchProduct = async () => {
      try {
        const productId = router.currentRoute.value.params.id;
        const response = await axios.get(`/api/products/${productId}`);
        product.value = response.data;
      } catch (error) {
        console.error(error);
      }
    };

    // Fetch categories
    const fetchCategories = async () => {
      try {
        const response = await axios.get("/api/categories");
        categories.value = response.data;
      } catch (error) {
        console.error(error);
      }
    };

    const updateProduct = async () => {
      try {
        const formData = new FormData();
        formData.append("name", product.value.name);
        formData.append("description", product.value.description);
        formData.append("price", product.value.price);
        formData.append("category_id", product.value.category_id);
        formData.append("image", product.value.image);

        await axios.post(`/api/product-update/${product.value.id}`, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        router.push({ name: "product-list" });
      } catch (error) {
        console.error(error);
      }
    };

    const handleImageUpload = (event) => {
      product.value.image = event.target.files[0];
    };

    const getImageUrl = (imagePath) => {
      if (imagePath) {
        return `${window.assetUrl}storage/${imagePath}`;
      } else {
        return null;
      }
    };

    onMounted(() => {
      fetchProduct();
      fetchCategories();
    });

    return {
      product,
      categories,
      updateProduct,
      getImageUrl,
      handleImageUpload,
    };
  },
};
</script>
