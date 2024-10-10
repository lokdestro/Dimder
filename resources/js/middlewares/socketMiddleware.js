import * as actions from '../actions/websocketActions.js';
import {
    WS_CONNECT, WS_DISCONNECT,
    WS_SEND_MESSAGE, 
    ADD_MESSAGE
} from "../actions/constants.js";
import {
    MESSAGE_TYPE
} from "../constants/message.js";


const socketMiddleware = () => {
    let wsSocket = null;
    const onMessage = (store, event) => {
        console.log('WebSocket onMessage payload = ', payload);
        const payload = JSON.parse(event.data);
        const payloadType =  payload.type;
        switch (payloadType) {
            case MESSAGE_TYPE:
                store.dispatch({
                    type: ADD_MESSAGE,
                    payload: payload
                });
            default:
                break;
        }
    };

    const onOpen = (event, store, payload) => {
        console.log('WebSocket connected');
        // Дополнительные действия при открытии соединения
    };

    const onClose = (store, payload, event) => {
        console.log('WebSocket closed. Reconnecting...', event);
        setTimeout(() => {

            initSocket(store, payload);
        }, 3000);
    };

    const onError = (event) => {
        console.log('WebSocket error observed:', event);
    };

    
    const  initSocket = (store, payload)=>{
        if ((wsSocket === null || (wsSocket && wsSocket.readyState === 3)) )  {
            wsSocket = new WebSocket("ws://localhost:8080");
            wsSocket.onmessage = (event) => onMessage(store, event);
            wsSocket.onopen = (event) => onOpen(event, store, payload);
            wsSocket.onclose = (event) => onClose(store, payload, event);
            wsSocket.onerror = (event) => onError(event);

            console.log("   -- 1  initSocket   wsSocket = ", wsSocket)
        }
        
    }

    return store => next => action => {
        switch (action.type) {
            case WS_CONNECT:

                initSocket(store, action.payload);
                break;
               
            case WS_DISCONNECT:
                if (wsSocket !== null) {
                    wsSocket.close();
                }
                wsSocket = null;

                break;
            case WS_SEND_MESSAGE:
                console.log("   --    2  wsSocket = ", wsSocket)
                if (wsSocket !== null && wsSocket.readyState === 1) {
                    const sendMessage = action.payload;
                    console.log("send   --   message")
                    wsSocket.send(JSON.stringify(sendMessage));
                }
                break;
            default:
                return next(action);
        }
    };
};

export default socketMiddleware();
