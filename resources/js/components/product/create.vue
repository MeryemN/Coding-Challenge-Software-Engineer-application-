<template>
  <div>
    <h2>Create Product</h2>
    <form @submit.prevent="submitForm">
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
        <input
          type="text"
          class="form-control"
          id="description"
          v-model="product.description"
        />
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
        <input
          type="file"
          class="form-control"
          id="image"
          @change="handleImageUpload"
          required
        />
      </div>
      <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

export default {
  setup() {
    const product = ref({
      name: "",
      description: "",
      price: "",
      category_id: "", // Initialize to an empty string
      image: null,
    });

    const categories = ref([]);

    const router = useRouter();

    const submitForm = async () => {
      try {
        const formData = new FormData();
        formData.append("name", product.value.name);
        formData.append("description", product.value.description);
        formData.append("price", product.value.price);
        formData.append("category_id", product.value.category_id);
        formData.append("image", product.value.image);

        const response = await axios.post("/api/products", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        console.log("Product created:", response.data);

        // Redirect to the product list
        router.push({ name: "product-list" });
      } catch (error) {
        console.error(error);
      }
    };

    const handleImageUpload = (event) => {
      product.value.image = event.target.files[0];
    };

    onMounted(async () => {
      // Fetch categories from the API and populate the categories array
      try {
        const response = await axios.get("/api/categories"); // Adjust the endpoint as needed
        categories.value = response.data;
      } catch (error) {
        console.error(error);
      }
    });

    return {
      product,
      categories,
      submitForm,
      handleImageUpload,
    };
  },
};
</script>
