<template>
  <div id="dashboard" class="row">
    <div id="sidebar">
      <h1>Company</h1>
      <div class="column" id="topics">
        <div class="between row">
          <div class="row center">
            <arrow-left-icon
              size="1.7x"
              class="add-button back-button"
              v-if="topicSelected"
              @click="topicSelected = false"
            ></arrow-left-icon>
            <h2>{{topicSelected || "Topics"}}</h2>
          </div>
          <plus-circle-icon size="1.7x" class="add-button" @click="showTopicOrArticle"></plus-circle-icon>
        </div>
        <div v-if="createNewTopic" class="row between center" id="topic-input">
          <input type="text" v-model="newTopic" placeholder="Name your new topic" />
          <plus-circle-icon size="1.7x" class="add-button" @click="createTopic"></plus-circle-icon>
        </div>
        <div class="row between wrap" v-if="!topicSelected">
          <div
            class="card"
            @click="topicSelected = item.name; filterArticles(item.name)"
            v-for="(item, index) in topics"
            :key="index"
          >
            <clock-icon size="1.75x" class="custom-class"></clock-icon>
            <h3>{{item.name}}</h3>
          </div>
        </div>
        <div class="articles" v-if="topicSelected">
          <div
            class="article-card"
            v-for="(item, index) in filteredArticles"
            :key="index"
            @click="selectArticle(index); editing = true"
          >
            <h3>{{item.title}}</h3>
            <p>{{item.updated_at | moment("from", true)}}</p>
          </div>
        </div>
      </div>
    </div>
    <div id="main">
      <img src="/css/images/ZombieingDoodle.svg" alt v-if="!selected" />
      <div class="editor" v-if="selected">
        <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
          <div class="menubar">
            <div class="row center">
              <label class="dropdown">
                <div class="dd-button">{{dropdown}}</div>

                <input type="checkbox" class="dd-input" id="test" />

                <ul class="dd-menu">
                  <li
                    id="header"
                    class="menubar__li"
                    :class="{ 'is-active': isActive.heading({ level: 1 }) }"
                    @click="commands.heading({ level: 1 }); dropdown = 'Header'"
                  >
                    <h1>Header</h1>
                  </li>

                  <li
                    id="subheader"
                    class="menubar__li"
                    :class="{ 'is-active': isActive.heading({ level: 2 }) }"
                    @click="commands.heading({ level: 2 }); dropdown = 'Subheader'"
                  >
                    <h3>Subheader</h3>
                  </li>

                  <li
                    id="title"
                    class="menubar__li"
                    :class="{ 'is-active': isActive.heading({ level: 3 }) }"
                    @click="commands.heading({ level: 3 }); dropdown = 'Title'"
                  >
                    <h4>Title</h4>
                  </li>

                  <li
                    id="text"
                    class="menubar__li"
                    :class="{ 'is-active': isActive.paragraph() }"
                    @click="commands.paragraph; dropdown = 'Text'"
                  >Text</li>
                </ul>
              </label>
              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.bold() }"
                @click="commands.bold"
              >
                <font-awesome-icon :icon="['fas', 'bold']" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.italic() }"
                @click="commands.italic"
              >
                <font-awesome-icon :icon="['fas', 'italic']" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.strike() }"
                @click="commands.strike"
              >
                <font-awesome-icon :icon="['fas', 'strikethrough']" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.underline() }"
                @click="commands.underline"
              >
                <font-awesome-icon :icon="['fas', 'underline']" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.code() }"
                @click="commands.code"
              >
                <font-awesome-icon :icon="['fas', 'terminal']" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.bullet_list() }"
                @click="commands.bullet_list"
              >
                <font-awesome-icon :icon="['fas', 'list-ul']" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.ordered_list() }"
                @click="commands.ordered_list"
              >
                <font-awesome-icon :icon="['fas', 'list-ol']" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.blockquote() }"
                @click="commands.blockquote"
              >
                <font-awesome-icon :icon="['fas', 'quote-right']" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.code_block() }"
                @click="commands.code_block"
              >
                <font-awesome-icon :icon="['fas', 'code']" />
              </button>
              <button class="menubar__button" @click="showImagePrompt(commands.image)">
                <font-awesome-icon :icon="['fas', 'image']" />
              </button>
            </div>
            <div class="row center">
              <p class="warning">There are unsaved changes</p>
              <button id="save" @click="add = !add" v-if="!editing">Create</button>
              <button id="save" @click="updateArticle" v-if="editing">Save</button>
            </div>
          </div>
        </editor-menu-bar>
        <editor-content class="editor__content" :editor="editor" />
      </div>
      <div id="modal" v-if="add">
        <div class="background"></div>
        <input type="text" name="title" id="modal-title" v-model="title" placeholder="Title" />
        <select name="topic-drop" id="topic-drop" v-model="topic">
          <option disabled value>{{ topicSelected || 'Select a topic'}}</option>
          <option v-for="(item, index) in topics" :key="index">{{item.name}}</option>
        </select>
        <div class="row between button-wrapper">
          <div class="save row center" @click="createArticle">
            <p>Add</p>
          </div>
          <div class="cancel row center" @click="add = false">
            <x-icon size="1.7x" class="custom-class"></x-icon>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {
  PlusCircleIcon,
  ClockIcon,
  ArrowLeftIcon,
  XIcon
} from "vue-feather-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { Editor, EditorContent, EditorMenuBar } from "tiptap";
import {
  Blockquote,
  CodeBlock,
  HardBreak,
  Heading,
  OrderedList,
  BulletList,
  ListItem,
  TodoItem,
  TodoList,
  Bold,
  Code,
  Italic,
  Link,
  Strike,
  Underline,
  History,
  Image
} from "tiptap-extensions";
import axios from "axios";

export default {
  name: "dashboard",
  data() {
    return {
      topics: [],
      articles: [],
      filteredArticles: [],
      topicSelected: false,
      selected: false,
      editedArticle: {},
      editing: false,
      add: false,
      title: "",
      topic: "",
      newTopic: "",
      createNewTopic: false,
      articleHTML: "",
      dropdown: "Header",
      editor: new Editor({
        extensions: [
          new Blockquote(),
          new BulletList(),
          new CodeBlock(),
          new HardBreak(),
          new Heading({ levels: [1, 2, 3] }),
          new ListItem(),
          new OrderedList(),
          new TodoItem(),
          new TodoList(),
          new Link(),
          new Bold(),
          new Code(),
          new Italic(),
          new Strike(),
          new Underline(),
          new History(),
          new Image()
        ],
        content:
          "<h1>This is a category</h1><p></p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Volutpat odio facilisis mauris sit amet. Nibh nisl condimentum id venenatis a condimentum. Malesuada fames ac turpis egestas sed tempus. Dictumst quisque sagittis purus sit amet volutpat consequat. Ac turpis egestas integer eget. Tortor condimentum lacinia quis vel eros donec ac odio tempor. Sagittis id consectetur purus ut faucibus pulvinar elementum integer. Est placerat in egestas erat imperdiet sed euismod nisi. Est ante in nibh mauris cursus. At varius vel pharetra vel turpis nunc. At imperdiet dui accumsan sit amet. Sit amet massa vitae tortor condimentum lacinia quis vel. Ac odio tempor orci dapibus ultrices in iaculis. Neque aliquam vestibulum morbi blandit cursus risus at ultrices.</p><h2>Content</h2><p>Fermentum posuere urna nec tincidunt praesent semper. Viverra nam libero justo laoreet sit amet. Volutpat lacus laoreet non curabitur gravida. A diam maecenas sed enim. Augue eget arcu dictum varius duis at consectetur lorem donec. Risus nec feugiat in fermentum posuere. Elementum tempus egestas sed sed risus pretium quam vulputate dignissim. Eu facilisis sed odio morbi quis commodo. Cras adipiscing enim eu turpis. In dictum non consectetur a erat. Cras tincidunt lobortis feugiat vivamus at augue eget arcu. Lectus quam id leo in vitae.</p><p>At elementum eu facilisis sed odio. Eu turpis egestas pretium aenean pharetra magna ac placerat vestibulum. Et netus et malesuada fames. Felis imperdiet proin fermentum leo vel orci. Facilisis gravida neque convallis a cras semper. Ultrices sagittis orci a scelerisque. Diam phasellus vestibulum lorem sed risus ultricies tristique nulla. Faucibus in ornare quam viverra orci sagittis eu volutpat. Placerat in egestas erat imperdiet sed euismod nisi porta. Consequat nisl vel pretium lectus quam id. Mauris vitae ultricies leo integer malesuada nunc. Aliquet sagittis id consectetur purus ut faucibus pulvinar elementum integer.</p><h2>More Content</h2><p>Eu ultrices vitae auctor eu augue ut lectus arcu. Non odio euismod lacinia at quis risus sed vulputate. Ultrices gravida dictum fusce ut placerat orci nulla pellentesque. Enim neque volutpat ac tincidunt vitae semper quis lectus nulla. Lacus laoreet non curabitur gravida. In est ante in nibh mauris cursus. Maecenas volutpat blandit aliquam etiam. Feugiat pretium nibh ipsum consequat nisl vel. Aliquet enim tortor at auctor urna. Tempus iaculis urna id volutpat lacus laoreet non curabitur. Hendrerit dolor magna eget est lorem. Maecenas ultricies mi eget mauris pharetra et ultrices.</p><p></p><p>Bibendum neque egestas congue quisque egestas diam. Ultricies integer quis auctor elit sed. Gravida cum sociis natoque penatibus et magnis. In hac habitasse platea dictumst vestibulum rhoncus est. Massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada. Nulla posuere sollicitudin aliquam ultrices sagittis orci a scelerisque purus. Nunc consequat interdum varius sit amet mattis vulputate enim. Vitae justo eget magna fermentum. Velit scelerisque in dictum non consectetur. Facilisis gravida neque convallis a cras semper auctor neque vitae. Nisl rhoncus mattis rhoncus urna neque viverra justo nec. Et egestas quis ipsum suspendisse ultrices gravida dictum. At volutpat diam ut venenatis tellus in metus vulputate. Sagittis orci a scelerisque purus.</p><h1>this is the end</h1>",
        onUpdate: ({ getHTML }) => {
          this.articleHTML = getHTML();
        }
      })
    };
  },
  components: {
    EditorContent,
    EditorMenuBar,
    PlusCircleIcon,
    ClockIcon,
    ArrowLeftIcon,
    XIcon,
    "font-awesome-icon": FontAwesomeIcon
  },
  methods: {
    showTopicOrArticle: function() {
      if (this.topicSelected) {
        this.selected = !this.selected;
        console.log("Show editor");
      } else {
        this.createNewTopic = !this.createNewTopic;
        console.log("show topic input");
      }
    },
    showImagePrompt(command) {
      const src = prompt("Enter the url of your image here");
      if (src !== null) {
        command({ src });
      }
    },
    createArticle: function() {
      if (this.topic == "") {
        this.topic = this.topicSelected;
      }

      axios
        .post("/create", {
          title: this.title,
          content: this.articleHTML,
          topic: this.topic
        })
        .then(function(response) {
          alert("Created!");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    createTopic: function() {
      axios
        .post("/createTopic", {
          name: this.newTopic,
          count: 0
        })
        .then(function(response) {
          alert("Created!");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    getData: function() {
      axios
        .get(`/api/articles`)
        .then(res => {
          if (res.status == 200) {
            this.articles = res.data;
          }
        })
        .catch(err => {
          console.log(err);
        });

      axios
        .get(`/api/topics`)
        .then(res => {
          if (res.status == 200) {
            this.topics = res.data;
          }
        })
        .catch(err => {
          console.log(err);
        });
    },
    filterArticles: function(topic) {
      this.filteredArticles = [];
      this.articles.forEach(article => {
        if (article.topic == topic) {
          this.filteredArticles.push(article);
        }
      });
    },
    selectArticle: function(id) {
      console.log("Index: " + id);

      this.selected = true;

      this.editedArticle = this.filteredArticles[id];

      // Clear the editor before each selection
      this.editor.clearContent(true);
      // Set content, in our case an html string
      this.editor.setContent(this.editedArticle.content);
      this.editor.focus();
    },
    updateArticle: function() {
      axios
        .post("/updateArticle", {
          id: this.editedArticle.id,
          content: this.articleHTML
        })
        .then(function(response) {
          alert("Updated!");
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  mounted() {
    this.getData();
  },
  beforeDestroy() {
    this.editor.destroy();
  }
};
</script>

<style lang="scss" scoped>
.warning {
  color: #fd934c;
}

#dashboard {
  height: 100vh;
  color: #58687c;
  overflow: hidden;

  #sidebar {
    width: 500px;
    height: 100%;
    padding: 0 25px;
    background: #fde74c;

    #topic-input {
      position: relative;

      input[type="text"] {
        width: 100%;
        height: 50px;

        font-size: 1.4rem;
        background: #eaeef2;
        border-radius: 5px;
        border: 1px solid #b8c0c9;
        text-indent: 5px;
      }

      .add-button {
        position: absolute;
        top: 50%;
        right: 0%;
        transform: translate(-50%, -50%);
      }
    }

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

    .articles {
      display: flex;
      flex-direction: column;
      align-items: center;
      overflow-y: scroll;
      height: 76vh;

      .article-card {
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

      .back-button {
        margin-right: 10px;
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

    .editor {
      width: 100%;
      height: 100%;

      .editor__content {
        padding: 0 20px;
        overflow-y: scroll;
      }
    }

    .menubar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #ececec;
      padding: 10px 20px;
      box-shadow: 0 0px 5px rgba(0, 0, 0, 0.171);
    }

    #save {
      margin: 0px 5px;
      background: #fde74c;
      color: #58687c;
      height: 30px;
      width: 70px;
      border: none;
      outline: none;
      border-radius: 5px;
      font-size: 1rem;
      font-weight: 500;

      &:hover {
        cursor: pointer;
      }
    }

    .menubar__button {
      border: none;
      font-size: 1.35rem;
      color: #9b9b9b;
      outline: none;
      transition: 0.1s;
      margin: 0 5px;
      background: none;

      &:hover {
        color: #58687c;
        cursor: pointer;
        transform: scale(1.2);
        background: none;
      }

      &:active {
        background: none;
      }

      &.is-active {
        color: #58687c;
        transform: scale(1.2);
        background: none;
      }
    }
  }
}

#modal {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  width: 500px;
  background: #fff;
  box-shadow: 0px 4px 305px rgba(0, 0, 0, 0.45);
  padding: 140px 40px 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-direction: column;

  .background {
    background: #fde74c;
    height: 110px;
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    background-image: url("/css/images/Background.png");
    background-position: center;
    background-size: 120%;
  }

  input {
    -ms-box-sizing: content-box;
    -moz-box-sizing: content-box;
    -webkit-box-sizing: content-box;
    box-sizing: content-box;
  }

  input[type="text"] {
    width: 450px;
    height: 50px;

    font-size: 1.4rem;
    background: #eaeef2;
    border-radius: 5px;
    border: 1px solid #b8c0c9;
    margin-bottom: 15px;
    text-indent: 5px;
  }

  select {
    width: 454px;
    height: 54px;

    font-size: 1.4rem;
    background: #eaeef2;
    border-radius: 5px;
    border: 1px solid #b8c0c9;
    margin-bottom: 15px;
  }

  .button-wrapper {
    width: 50%;
  }

  .save {
    width: 100%;
    background: #fde74c;
    padding: 15px 25px;
    border: none;
    font-size: 1.4rem;
    border-radius: 5px;
    margin-right: 25px;
    color: #58687c !important;

    p {
      margin: 0;
    }

    &:hover {
      cursor: pointer;
    }
  }

  .cancel {
    background-color: #fd4c4c;
    color: #58687c !important;
    border: none;
    padding: 15px;
    border-radius: 5px;

    &:hover {
      cursor: pointer;
    }

    option {
      color: #58687c !important;
    }
  }
}

/* Dropdown */

.dropdown {
  display: inline-block;
  position: relative;
}

.dd-button {
  display: inline-block;
  border-radius: 4px;
  padding: 10px 20px 10px 20px;
  background-color: #dbdbdb;
  cursor: pointer;
  white-space: nowrap;
  width: 100px;
}

.dd-button:after {
  content: "";
  position: absolute;
  top: 50%;
  right: 15px;
  transform: translateY(-50%);
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-top: 5px solid #58687c;
}

.dd-button:hover {
  background-color: #dbdbdb;
}

.dd-input {
  display: none;
}

.dd-menu {
  position: absolute;
  z-index: 1;
  top: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 0px;
  margin: 2px 0 0 0;
  box-shadow: 0 0 6px 0 rgba(0, 0, 0, 0.1);
  background-color: #ffffff;
  list-style-type: none;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.dd-input + .dd-menu {
  display: none;
}

.dd-input:checked + .dd-menu {
  display: block;
}

.dd-menu li {
  padding: 10px 40px;
  cursor: pointer;
  white-space: nowrap;
}

.dd-menu li:hover {
  background-color: #f6f6f6;
}

li h1,
h3,
h4 {
  margin: 0;
}
</style>