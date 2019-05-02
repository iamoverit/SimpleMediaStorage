import {Component, EventEmitter, Output, ViewChild} from '@angular/core';
import {FileUploadService} from './services/file-upload.service';
import {AlertMessageComponent} from './alert-message/alert-message.component';

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
    private handleError(Error: ErrorConstructor): any {
        this.alertMessageComponent.setError('Upload error.');
    }

    private handleSuccess(result: any) {
        this.alertMessageComponent.setSuccess('File has been successfully uploaded, you will soon receive an email link.');
    }
    constructor(private fileUploadService: FileUploadService) {
    }

    uploadFileToActivity() {
        event.preventDefault();
        if (this.fileList != null && this.fileList.length > 0) {
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

}

