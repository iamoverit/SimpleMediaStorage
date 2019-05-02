import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {FileUploadService} from './services/file-upload.service';
import {HttpClientModule} from '@angular/common/http';
import {AlertMessageComponent} from './alert-message/alert-message.component';

@NgModule({
    declarations: [
        AppComponent,
        AlertMessageComponent,
    ],
    imports: [
        BrowserModule,
        AppRoutingModule,
        HttpClientModule
    ],
    providers: [FileUploadService],
    bootstrap: [AppComponent]
})
export class AppModule {
}
