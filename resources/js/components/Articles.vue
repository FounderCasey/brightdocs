<template>
  <div id="articles" class="row">
    <div id="sidebar">
      <div class="row center pad-top" id="title-container">
        <font-awesome-icon
          :icon="['fas', 'arrow-left']"
          class="arrow"
          @click="selectArticle('home')"
        />
        <h1>{{topic}}</h1>
      </div>
      <div class="cards">
        <div
          class="card"
          v-for="(item, index) in articles"
          :key="index"
          @click="selectArticle(item.id); selected = true"
        >
          <h3>{{item.title}}</h3>
          <p>{{ item.updated_at | moment("from", true) }} ago</p>
        </div>
      </div>
    </div>

    <div id="main">
      <img src="/css/images/ZombieingDoodle.svg" v-if="!selected" />
      <div v-if="selected" class="container">
        <p>{{article.title}}</p>
        <p v-html="article.content"></p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default {
  name: "articles",
  data() {
    return {
      articles: [],
      article: {},
      selected: false
    };
  },
  props: {
    topic: String
  },
  methods: {
    getArticles: function() {
      axios
        .get(`/api/${this.topic.toLowerCase()}/articles`)
        .then(res => {
          if (res.status == 200) {
            console.log(res);
            this.articles = res.data;
          }
        })
        .catch(err => {
          console.log(err);
        });
    },
    selectArticle: function(id) {
      if (id == "home") {
        window.location.replace("/app");
      } else {
        axios
          .get(`/api/${this.topic}/articles/${id}`)
          .then(res => {
            if (res.status == 200) {
              this.article = res.data[0];
            }
          })
          .catch(err => {
            console.log(err);
          });
      }
    }
  },
  mounted() {
    this.getArticles();
  },
  components: {
    "font-awesome-icon": FontAwesomeIcon
  }
};
</script>

<style lang="scss" scoped>
.container {
  overflow-y: scroll;
  height: 100vh;
  padding: 0 45px;
  text-align: left;
  width: 100%;
}

.arrow {
  font-size: 1.5rem;

  &:hover {
    color: #fafcff;
    cursor: pointer;
  }
}

#articles {
  height: 100vh;
  overflow: hidden;
}

#sidebar {
  width: 500px;
  height: 100%;
  background: #fde74c;
  padding: 0 25px;

  #title-container {
    margin: auto;
    width: 95%;

    h1 {
      margin: 0;
      //font-size: 2.8125rem;
      font-size: 3vh;
      text-align: center;
      width: 100%;
      text-transform: capitalize;
    }
  }

  .cards {
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow-y: scroll;

    margin-top: 25px;

    height: 90vh;
    width: 410px;

    .card {
      width: 95%;
      min-height: 85px;
      border: solid #fafcff;
      background: #fafcff;
      border-radius: 5px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      margin: 10px 0px;

      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;

      &:hover {
        border: solid #58687c;
        cursor: pointer;
      }

      h3,
      p {
        margin: 0;
        padding-left: 25px;
      }

      p {
        color: #b8c0c9;
        font-weight: 100;
        padding-top: 3px;
        font-size: 0.9rem;
      }
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

#main {
  position: relative;
  background: #fafcff;
  height: 100%;
  width: 100%;

  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;

  img {
    height: 75%;
    opacity: 1;
  }
}
</style>