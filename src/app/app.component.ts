import {Component, NgModule} from '@angular/core';
import {FileUploadService} from './services/file-upload.service';

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

    private static handleError(Error: ErrorConstructor): any {
        console.log(`UploadError: ${Error.toString()}`);
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
            }).subscribe(data => {
                    console.log('success');
                }, error => {
                    AppComponent.handleError(error);
                });
        }
    }
}

