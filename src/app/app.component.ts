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
            // const formData = new FormData();
            // formData.append('fileContent', this.fileList[0]);
            // formData.append('fileDescription', this.fileDescription);
            // formData.append('fileSenderEmail', this.fileSenderEmail);
            this.fileUploadService.sendFile(this.fileList).subscribe(data => {
                console.log('success');
            }, error => {
                AppComponent.handleError(error);
            });
        }
    }
}

