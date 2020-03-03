<template>
  <div id="navbar">
    <nav>
      <div id="logo-container">
        <div class="logo"></div>
        <h2>BrightDocs</h2>
      </div>
      <div class="container">
        <button>Sign Up</button>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: "StaticNavbar"
};
</script>

<style lang="scss" scoped>
#navbar {
  width: 1198px;
  margin: auto;
  nav {
    display: flex;
    justify-content: space-between;
    background: #fafcff;
    color: #58687c;

    #logo-container {
      display: flex;
      justify-content: center;
      align-items: center;

      .logo {
        height: 30px;
        width: 30px;
        background: #fde74c;
        border-radius: 50px;
        margin: 0 10px 0 5px;
      }
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;

      button {
        margin: 0px 5px;
        background: #fde74c;
        height: 50px;
        width: 100px;
        border: none;
        outline: none;
        border-radius: 5px;
        font-size: 1.1rem;
        font-weight: 500;

        &:hover {
          cursor: pointer;
        }
      }
    }
  }
}
</style>