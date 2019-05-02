import {Component, EventEmitter, Output, ViewChild} from '@angular/core';
import {FileUploadService} from './services/file-upload.service';
import {AlertMessageComponent} from './alert-message/alert-message.component';
import {ValidationErrors} from '@angular/forms';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.css']
})
export class AppComponent {
    title = 'SimpleMediaStorage';
    fileList: FileList = null;
    fileDescription = '';
    fileSenderEmail = '';
    @ViewChild(AlertMessageComponent)
    private alertMessageComponent: AlertMessageComponent;

    private handleError(Error: ValidationErrors): any {
        let errors = [];
        if (Error.error.errors != null) {
            let prop: string;
            const errorsProps = Object.keys(Error.error.errors);
            for (prop of errorsProps) {
                errors.push(Error.error.errors[prop]);
            }
            errors = errors.flat();
        } else if (Error.message != null) {
            errors.push(Error.message);
        }
        this.alertMessageComponent.setError('Upload error.', errors);
    }

    private handleSuccess(result: any) {
        this.alertMessageComponent.setSuccess('File has been successfully uploaded, you will soon receive an email link.');
    }

    constructor(private fileUploadService: FileUploadService) {
    }

    uploadFileToActivity() {
        event.preventDefault();
        this.fileUploadService.sendFile({
            fileList: this.fileList,
            fileDescription: this.fileDescription,
            fileSenderEmail: this.fileSenderEmail
        }).subscribe(
            result => {
                this.handleSuccess(result);
            }, error => {
                this.handleError(error);
            });
    }

}

