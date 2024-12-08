import { MESSAGE_TYPE} from '../constants/message.js';
import {  WS_CONNECT, WS_CONNECTED, WS_DISCONNECT, WS_DISCONNECTED, WS_SEND_MESSAGE } from './constants.js';

export const wsConnect = () => ({type: WS_CONNECT});
export const wsConnected = () => ({type: WS_CONNECTED});
export const wsDisconnect = () => ({type: WS_DISCONNECT});
export const wsDisconnected = () => ({type: WS_DISCONNECTED});

const time = Date.now();


export const sendMessage = (body, clientId) => (dispatch, getState) =>{
    console.log("  ----   sendMessage ---2-")
    dispatch({
        type: WS_SEND_MESSAGE,
        payload: {
            type: 'init',
            body: body,
            sender_id: time,
            consumer_id: 2
        }
    });
    dispatch({
        type: WS_SEND_MESSAGE,
        payload: {
            type: 'message',
            body: body,
            sender_id: time,
            consumer_id: time
        }
    });
}

export const connectToServer = () => (dispatch, getState) =>
    new Promise((resolve, reject) => {

        dispatch({
            type: WS_CONNECT,
            payload: ''
        });
        resolve();
    });
//
export const disConnectToServer = () => (dispatch, getState) =>
    new Promise((resolve, reject) => {

        dispatch({
            type: WS_DISCONNECT,
            payload: ''
        });
        resolve();
    });