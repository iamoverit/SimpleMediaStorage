import {Component, Input, OnInit, Output} from '@angular/core';

@Component({
    selector: 'app-alert-message',
    templateUrl: './alert-message.component.html',
    styleUrls: ['./alert-message.component.css']
})
export class AlertMessageComponent implements OnInit {
    message: string;
    currentClasses: {};

    constructor() {
    }

    ngOnInit() {
    }

    setSuccess(message: string) {
        this.currentClasses = [
            'alert',
            'alert-success'
        ];
        this.message = message;
    }

    setError(message: string) {
        this.currentClasses = [
            'alert',
            'alert-danger'
        ];
        this.message = message;
    }
}
