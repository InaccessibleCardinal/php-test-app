function fakeGuid() {
  return Math.random().toString(36).substring(2, 15) +
      Math.random().toString(36).substring(2, 15);
}

function makeTodo(text) {
  return {text, completed: false, id: fakeGuid()};
}

function createTodoStore(fn) {
  const subscriber = fn;
  let todos = [];
  const update = (action, todo) => {
    switch (action) {
      case 'ADD':
        todos = todos.concat(todo);
        return subscriber(todos);
      case 'REMOVE':
        todos = todos.filter(t => t.id !== todo.id);
        return subscriber(todos);
      default:
        return;
    }  
  }
  subscriber(todos);
  return {update};
}

function createForm(target) {
  const ul = $('<ul>', {id: 'mylist'});
  target.append(ul);
  const button = $('<button>', {id: 'mybutton', text: 'Add'});
  const input = $('<input>', {id: 'myinput'});
  target.append(input);
  target.append(button);
  return {ul, button, input};
}

function buildTodoItem(todo, update) {
  const li = $('<li>');
  const p = $('<p>', {text: todo.text});
  const button = $('<button>', {text: 'remove'});
  button.on('click', () => update('REMOVE', todo));
  li.append(p);
  li.append(button);
  return li;
}

function makeTodoList() {
  const { ul, button, input} = createForm($('body'));
  const {update} = createTodoStore(render);

  function render(todos) {
    const newTodoList = todos.map(t => buildTodoItem(t, update));
    ul.html(newTodoList);
  }

  $(button).click(function() {
    if (input.val()) {
      update('ADD', makeTodo(input.val()));
      input.val('');
      input.focus();
    }
  });
}

$('document').ready(makeTodoList);