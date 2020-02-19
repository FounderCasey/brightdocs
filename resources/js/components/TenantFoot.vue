<template>
  <div id="foot">
    <footer class="row between">
      <div id="links" class="row center">
        <h2 class="link">Company</h2>
        <a href="#" class="link">Get Help</a>
        <a href="/dashboard" class="link" v-if="user.name != ''">Dashboard</a>
        <a href="/dashboard" class="link" v-else>Login</a>
      </div>
      <div class="row center">
        <zap-icon size="1.1x" class="icon"></zap-icon>
        <p>
          Powered by
          <span>
            <a href="//brightdocs.test">BrightDocs</a>
          </span>
        </p>
      </div>
    </footer>
  </div>
</template>

<script>
import { ZapIcon } from "vue-feather-icons";

export default {
  name: "tenant-foot",
  props: {
    user: Object
  },
  components: {
    ZapIcon
  }
};
</script>

<style lang='scss' scoped>
#foot {
  width: 100%;
  background: #fafcff;
  a {
    text-decoration: none;
    color: #58687c;

    &:hover {
      color: #fde74c;
    }
  }
}

footer {
  color: #58687c;
  width: 1198px;
  margin: auto;
  padding: 20px 0;

  #links {
    .link {
      padding: 0 10px;
      margin: 0 5px;
    }

    h2 {
      font-weight: 500;
    }
  }

  .icon {
    color: #fde74c;
    padding-right: 5px;
  }

  span {
    border-bottom: #fde74c solid 3px;
    padding-bottom: 2px;
  }
}
</style>