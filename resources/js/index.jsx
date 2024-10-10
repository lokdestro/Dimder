require('./bootstrap');
import React, { Component } from 'react';
import { createRoot } from 'react-dom/client';
import { Provider } from 'react-redux';
import { createStore, applyMiddleware, compose } from 'redux';
import rootReducer from './reducers/index.js';
import socketMiddleware from './middlewares/socketMiddleware.js';
import { thunk } from 'redux-thunk';


import ChatContainer from "./components/ChatContainer.js";

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
const middlewares = [thunk, socketMiddleware];

let subscribeValue = [   {name: 'message', initial: "", value: ""},
                         
                        ];

const oldState = newLoadState();

const enhancer = composeEnhancers(
    applyMiddleware(...middlewares),

);
const store = createStore(rootReducer, oldState , enhancer);


const newSaveState = () => {
  subscribeValue = subscribeValue.map((item)=>{
      let previousValue = item.value;
      let newValue = store.getState()[item.name];
      if (previousValue !== newValue) {
          item.value = newValue;
          try {
              const serialisedState = JSON.stringify(newValue);
              window.localStorage.setItem(item.name, serialisedState);
          } catch (err) {
          }
      }
      return item;
  })
};

store.subscribe(() => {
  newSaveState();
});

function newLoadState() {
  let jsonP = {};
  subscribeValue.map((item)=>{
      try {
          const newValue = window.localStorage.getItem(item.name);
          const jsonPItem = ( ! newValue)
                                  ? item.initial
                                  : JSON.parse(newValue);
          jsonP = {...jsonP, [item.name]:jsonPItem};
      } catch (err) {
      }

  })
  if (Object.keys(jsonP).length === 0){
      return undefined;
  }else{
      return jsonP;
  }
};

class App extends Component {
    render() {
        return (
            <Provider store={store}>
                <React.Fragment>
                    <ChatContainer {...this.props}/>
                </React.Fragment>
            </Provider>
        );
    }
}

const container = document.getElementById('root');
if (container){
    const root = createRoot(container);
   
    root.render(<App/>);
}
