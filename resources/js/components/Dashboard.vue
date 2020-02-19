<template>
  <div id="dashboard" class="row">
    <div id="sidebar">
      <h1>Company</h1>
      <div class="column" id="topics">
        <div class="between row">
          <h2>Topics</h2>
          <plus-circle-icon size="1.7x" class="add-button" @click="selected = !selected"></plus-circle-icon>
        </div>
        <div class="row between wrap">
          <div class="card" @click="selected = 1">
            <clock-icon size="1.75x" class="custom-class"></clock-icon>
            <h3>Quickstart</h3>
          </div>
          <div class="card">
            <clock-icon size="1.75x" class="custom-class"></clock-icon>
            <h3>Quickstart</h3>
          </div>
          <div class="card">
            <clock-icon size="1.75x" class="custom-class"></clock-icon>
            <h3>Quickstart</h3>
          </div>
          <div class="card">
            <clock-icon size="1.75x" class="custom-class"></clock-icon>
            <h3>Quickstart</h3>
          </div>
          <div class="card">
            <clock-icon size="1.75x" class="custom-class"></clock-icon>
            <h3>Quickstart</h3>
          </div>
          <div class="card">
            <clock-icon size="1.75x" class="custom-class"></clock-icon>
            <h3>Quickstart</h3>
          </div>
          <div class="card">
            <clock-icon size="1.75x" class="custom-class"></clock-icon>
            <h3>Quickstart</h3>
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
              <button id="save" @click="add = !add">Save</button>
            </div>
          </div>
        </editor-menu-bar>
        <editor-content class="editor__content" :editor="editor" />
      </div>
      <div id="modal" v-if="add">
        <h2>Add an article</h2>
        <input type="text" name="title" id="modal-title" v-model="title" />
        <input type="text" name="topic" id="modal-topic" v-model="topic" />
        <button @click="createArticle">Add</button>
      </div>
    </div>
  </div>
</template>

<script>
import { PlusCircleIcon, ClockIcon } from "vue-feather-icons";
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
      selected: false,
      add: false,
      title: "",
      topic: "",
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
    "font-awesome-icon": FontAwesomeIcon
  },
  methods: {
    showImagePrompt(command) {
      const src = prompt("Enter the url of your image here");
      if (src !== null) {
        command({ src });
      }
    },
    createArticle: function() {
      axios
        .post("/create", {
          title: this.title,
          content: this.articleHTML,
          topic: this.topic
        })
        .then(function(response) {
          console.log(response);
          alert("Created!");
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  beforeDestroy() {
    // Always destroy your editor instance when it's no longer needed
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

  background: #fff;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  padding: 50px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-direction: column;

  button {
    margin-top: 25px;
    width: 100%;
    background: #fde74c;
    color: #58687c;
    padding: 5px 0;
    border: none;
    font-size: 1.4rem;
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