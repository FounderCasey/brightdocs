<template>
  <div id="register-user">
    <h1>Sign Up</h1>
    <form @submit.prevent="submit">
      <div>
        <label for="name">Name</label>
        <input
          type="text"
          class="form-control"
          name="name"
          id="name"
          v-model="fields.name"
          required
        />
        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
      </div>
      <div>
        <label for="email">Email</label>
        <input
          type="text"
          class="form-control"
          name="email"
          id="email"
          v-model="fields.email"
          required
        />
        <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
      </div>
      <div>
        <label for="role">Users Role</label>
        <select name="role" id="role" v-model="fields.role">
          <option disabled value>Please select one</option>
          <option value="Admin">Admin</option>
          <option value="User">User</option>
        </select>
        <div v-if="errors && errors.roles" class="text-danger">{{ errors.role[0] }}</div>
      </div>
      <div>
        <label for="password">Password</label>
        <input
          type="password"
          class="form-control"
          name="password"
          id="password"
          v-model="fields.password"
          required
        />
        <div v-if="errors && errors.message" class="text-danger">{{ errors.password[0] }}</div>
      </div>
      <div>
        <label for="message">Confirm Password</label>
        <input
          type="password"
          class="form-control"
          name="password_confirmation"
          id="password-confirm"
          v-model="fields.password_confirmation"
          required
        />
        <div v-if="errors && errors.message" class="text-danger">{{ errors.password[0] }}</div>
      </div>
      <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "register-user",
  data() {
    return {
      fields: {},
      errors: {}
    };
  },
  methods: {
    submit: function() {
      this.errors = {};
      axios
        .post("/register", this.fields)
        .then(response => {
          window.location.replace("/dashboard");
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          }
        });
    }
  }
};
</script>

<style></style>