import {Injectable} from '@angular/core';
import {
    HttpClient,
    HttpErrorResponse,
    HttpEvent,
    HttpEventType,
    HttpHeaders,
    HttpParams,
    HttpRequest
} from '@angular/common/http';
import {map, catchError, tap, last} from 'rxjs/operators';
import {environment} from '../../environments/environment';
import {throwError} from 'rxjs';


@Injectable({
    providedIn: 'root'
})

export class FileUploadService {
    constructor(private http: HttpClient) {
    }

    sendFile(options: { fileList: FileList; fileDescription: string; fileSenderEmail: string; }) {
        let file = null;
        if (options.fileList != null) {
            file = options.fileList[0];
        }
        const httpParams = new HttpParams()
            .append('fileDescription', options.fileDescription)
            .append('fileSenderEmail', options.fileSenderEmail);

        const formData = new FormData();
        formData.append('fileContent', file);
        const ret = this.http.post(`${environment.apiUrl}/file/`, formData, {
            params: httpParams
        }).pipe(catchError(err => this.handleError(err)));
        return ret;
    }

    private handleError(err: Error) {
        console.log(err);
        return throwError(err);
    }
}

