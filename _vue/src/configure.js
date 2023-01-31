import {EventEmitter as EventEmitterClass} from 'events';

/**
 * We instanciate one EventEmitter (restricted via a const) so that every components
 * register/dispatch on the same one and can communicate with each other.
 */
export const EventEmitter = new EventEmitterClass();

export default class EniBlogConfigure {
    constructor() {
        this.init();
      }
    
      init() {
        EventEmitter.on('PSComponentsInitiated', () => {
            console.debug('PSComponentsInitiated');
        });
      }
};

export const EniConfigure = new EniBlogConfigure();