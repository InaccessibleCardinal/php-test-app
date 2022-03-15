const {createElement, useState} = React;
const {render} = ReactDOM;

const buttonStyle = {cursor: 'pointer'};
function Counter() {
  const [count, setCount] = useState(0);

  const handleAddClick = () => setCount(count + 1);
  const handleSubClick = () => setCount(count - 1);
  
  const countDisplay = createElement('p', {key: 'display'}, `Count: ${count}`);
  const addButton = createElement(
    'button', 
    {onClick: handleAddClick, style: buttonStyle, key: '+button'}, 
    'Add'
  );
  const subtractButton = createElement(
    'button', 
    {onClick: handleSubClick,  style: buttonStyle, key: '-button'}, 
    'Subtract'
  );
  return createElement('div', null, [addButton, subtractButton, countDisplay]);
}

render(createElement(Counter, null, null), document.getElementById('root'));
