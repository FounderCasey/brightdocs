<template>
  <div id="articles">
    <div id="sidebar">
      <h1>Test</h1>
      <h3 v-for="(item, index) in articles" :key="index">{{item.title}}</h3>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "articles",
  data() {
    return {
      articles: []
    };
  },
  methods: {
    getArticle: function() {
      axios
        .get("/api/articles")
        .then(res => {
          if (res.status == 200) {
            console.log(res);
            this.articles = res.data;
          }
        })
        .catch(err => {
          console.log(err);
        });
    }
  },
  mounted() {
    this.getArticle();
  }
};
</script>

<style lang="scss" scoped>
#articles {
  height: 100vh;
}
#sidebar {
  width: 500px;
  height: 100%;
  padding: 0 25px;
  background: #fde74c;

  h1 {
    margin: 0;
    padding-top: 15px;
    font-size: 2.8125rem;
    text-align: center;
  }

  .card {
    width: 188px;
    height: 96px;
    border: solid #fafcff;
    background: #fafcff;
    border-radius: 5px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    margin: 10px 0px;

    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    h3 {
      margin-top: 5px;
      margin-bottom: 0;
    }

    &:hover {
      border: solid #58687c;
      cursor: pointer;
    }
  }

  #topics {
    width: 410px;
    margin: 25px auto 0;

    .add-button {
      &:hover {
        color: #fafcff;
        cursor: pointer;
      }
    }
  }
}
</style>