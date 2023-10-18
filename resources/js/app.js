import { createApp } from 'vue';
import { createWebHistory, createRouter } from 'vue-router'; // Import createWebHistory and createRouter
import axios from 'axios';
import VueAxios from 'vue-axios'

import App from './components/App.vue';
import CategoryList from './components/category/list.vue';
import CategoryCreate from './components/category/create.vue';
import CategoryEdit from './components/category/edit.vue';
import CategoryView from './components/category/view.vue';
import ProductList from './components/product/list.vue';
import ProductCreate from './components/product/create.vue';
import ProductEdit from './components/product/edit.vue';
import ProductView from './components/product/view.vue';

const app = createApp(App);

const routes = [
  { path: '/category-list', name: 'category-list', component: CategoryList },
  { path: '/category-create', name: 'category-create', component: CategoryCreate },
  { path: '/category-edit/:id', name: 'category-edit', component: CategoryEdit },
  //   { path: '/category-view', name: 'category-view',    component: CategoryView },
  { path: '/product-list', name: 'product-list', component: ProductList },
  { path: '/product-create', name: 'product-create', component: ProductCreate },
  { path: '/product-edit/:id', name: 'product-edit', component: ProductEdit },
  // { path: '/product-view', name: 'product-view',    component: ProductView },
  // Define routes for other components here
];

const router = createRouter({
  history: createWebHistory(),
  routes: routes
});

app.use(router); // Use the router
app.use(VueAxios, axios);
app.component('category-list', CategoryList);
app.component('category-create', CategoryCreate);
app.component('category-edit', CategoryEdit);
app.component('category-view', CategoryView);
app.component('product-list', ProductList);
app.component('product-create', ProductCreate);
app.component('product-edit', ProductEdit);
app.component('product-view', ProductView);

app.mount('#app');
