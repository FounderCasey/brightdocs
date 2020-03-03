<template>
  <div id="landing">
    <static-navbar></static-navbar>
    <div class="header row center">
      <div class="info">
        <h1>
          Assist your users by
          establishing
          a knowledgebase
        </h1>
        <p>
          BrightDocs provides a platform for building a knowledgebase
          <br />surrounding your
          <span>
            <vue-typer
              :text="[`App`,`Product`,`Community`,`Game`,`Platform`]"
              :repeat="Infinity"
              :shuffle="false"
              initial-action="typing"
              :pre-type-delay="100"
              :type-delay="100"
              :pre-erase-delay="2000"
              :erase-delay="250"
              erase-style="select-all"
              :erase-on-complete="false"
              caret-animation="blink"
              class="underline"
            ></vue-typer>
          </span>
        </p>
        <div id="searchbar">
          <search-icon size="1.5x" class="icon"></search-icon>
          <input type="text" placeholder="Enter your email" />
          <button>Stay Tuned</button>
        </div>
      </div>
      <img src="/css/images/ReadingDoodle.svg" alt />
    </div>
  </div>
</template>

<script>
import StaticNavbar from "./StaticNavbar";
import { VueTyper } from "vue-typer";

export default {
  name: "landing",
  components: {
    StaticNavbar,
    VueTyper
  }
};
</script>

<style lang="scss" scoped>
#landing {
  background: #fafcff;
  color: #58687c;

  .header {
    margin: 0 auto;
    width: 1198px;
    height: 75vh;

    text-align: left;

    .info {
      h1 {
        font-size: 2.8rem;
        margin: 0;
      }

      p {
        font-size: 1.5rem;
        margin: 30px 0;
      }

      #searchbar {
        background: #fff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        padding: 0 12px;
        width: 450px;
        margin-top: 0;

        display: flex;
        justify-content: center;
        align-items: center;
        color: #d5d9de;

        margin-bottom: 51px;
      }

      input[type="text"] {
        height: 60px;
        width: 350px;
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
        width: 120px;
        border-radius: 5px;
        font-size: 1.1rem;
        margin: 0;

        &:hover {
          cursor: pointer;
        }
      }
    }

    img {
      width: 60%;
      transform: scale(1.3) translateY(-25px);
      transition: 0.9s;
      animation: foldIn 1.3s;
    }
  }
}

@keyframes foldIn {
  0% {
    transform: rotateX(45deg) rotateZ(45deg) scale(1.3) translateY(-25px);
    opacity: 0;
  }
  100% {
    transform: rotateX(0deg) rotateZ(0deg) scale(1.3) translateY(-25px);
    opacity: 1;
  }
}

.underline {
  border-bottom: solid #fde74c;
  font-weight: bold;
}
</style>