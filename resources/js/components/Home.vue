<template>
  <div id="home">
    <tenant-navbar :company="tenant"></tenant-navbar>
    <header class="column center">
      <div id="search" class="column center">
        <h1>
          What are you
          <span>searching</span> for?
        </h1>
        <div id="searchbar">
          <search-icon size="1.5x" class="icon"></search-icon>
          <input type="text" placeholder="Let's narrow your search down..." />
          <button>Search</button>
        </div>
      </div>
      <div id="popular" class="column center">
        <p class="light-text">Not sure where to start? Here are some popular topics this week</p>
        <div class="row center">
          <div class="card">
            <h3>Quickstart</h3>
          </div>
          <div class="card">
            <h3>Quickstart</h3>
          </div>
          <div class="card">
            <h3>Quickstart</h3>
          </div>
          <div class="card">
            <h3>Quickstart</h3>
          </div>
        </div>
      </div>
    </header>
    <div id="topics">
      <div class="wrapper">
        <h2>Topics</h2>
        <div class="container">
          <div class="card" v-for="(item, index) in topics" :key="index">
            <div class="topic-icon">
              <clock-icon size="2x" class="custom-class"></clock-icon>
            </div>
            <div class="topic-info">
              <h4>{{item.name}}</h4>
              <p>{{item.count}} Articles</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { SearchIcon, ClockIcon } from "vue-feather-icons";
import TenantNavbar from "./TenantNavbar";
import axios from "axios";

export default {
  name: "home",
  data() {
    return {
      articles: [],
      topics: []
    };
  },
  props: {
    tenant: String
  },
  components: {
    "tenant-navbar": TenantNavbar,
    SearchIcon,
    ClockIcon
  },
  methods: {
    loadData: function() {
      axios
        .get("/api/articles")
        .then(res => {
          if (res.status == 200) {
            this.articles = res.data;
          }
        })
        .catch(err => {
          console.log(err);
        });

      axios
        .get("/api/topics")
        .then(res => {
          if (res.status == 200) {
            console.log(res.data);
            this.topics = res.data;
          }
        })
        .catch(err => {
          console.log(err);
        });
    }
  },
  mounted() {
    this.loadData();
  }
};
</script>

<style lang="scss" scoped>
#home {
  header {
    background: #fafcff;
    color: #58687c;
    height: 60vh;
    padding-bottom: 45px;

    #search {
      h1 {
        font-size: 2.8125rem;
      }

      span {
        border-bottom: #fde74c solid 4px;
        padding-bottom: 4px;
      }

      #searchbar {
        background: #fff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        padding: 0 12px;

        display: flex;
        justify-content: center;
        align-items: center;
        color: #d5d9de;

        margin-bottom: 51px;
      }

      .icon {
        padding-right: 12px;
      }

      input[type="text"] {
        height: 60px;
        width: 530px;
        border: none;
        outline: none;
        font-size: 1.1rem;
        color: #58687c;

        &::placeholder {
          color: #d5d9de;
        }
      }

      button {
        background: #fde74c;
        border: none;
        outline: none;
        font-weight: 500;
        height: 40px;
        width: 90px;
        border-radius: 5px;
        font-size: 1.1rem;
        margin: 0;

        &:hover {
          cursor: pointer;
        }
      }
    }

    #popular {
      .light-text {
        color: #b8c0ca;
        margin-bottom: 26px;
      }

      .card {
        width: 188px;
        height: 96px;
        border: solid #fafcff;
        border-radius: 5px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        margin: 0 21px;

        display: flex;
        justify-content: center;
        align-items: center;

        &:hover {
          border: solid #fde74c;
          cursor: pointer;
        }

        &:first-of-type {
          margin-left: 0;
        }

        &:last-of-type {
          margin-right: 0;
        }
      }
    }
  }

  #topics {
    background: #fde74c;
    color: #58687c;

    padding: 51px 0;

    .wrapper {
      width: 900px;
      margin: auto;

      h2 {
        font-weight: 500;
      }
    }

    .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .card {
      background: #fff;
      width: 48.15%;
      height: 85px;
      display: flex;
      justify-content: flex-start;
      align-items: center;
      border-radius: 5px;
      margin-bottom: 20px;
      border: #fff 3px solid;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);

      .topic-icon {
        margin: 0 20px;
      }

      .topic-info {
        h4,
        p {
          margin: 0;
          font-size: 1.3rem;
        }

        h4 {
          font-weight: 500;
        }

        p {
          font-size: 0.9rem;
          margin-top: 7px;
        }
      }

      &:hover {
        cursor: pointer;
        border: solid #58687c 3px;
      }
    }
  }
}
</style>