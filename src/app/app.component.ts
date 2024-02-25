import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { environment } from '../environments/environment';

interface LoginResponse {
  loggedIn: boolean;
  message: string;
}

interface DataResponse {
  success: boolean;
  data: any;
}

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet,FormsModule,CommonModule],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'my-angular-project';
  loggedIn = false;
  parenturl = environment.apiUrl;
  username: string='';
  password: string='';
  data: any;

  constructor(private http: HttpClient) {}

  ngOnInit(): void {
    // Check if the user is already logged in
    this.checkSession();
  }

  login(): void {
    this.http.post<LoginResponse>( this.parenturl + '/auth/login.php', { username: this.username, password: this.password }, { withCredentials: true })
      .subscribe(response => {
        if (response.loggedIn) {
          this.loggedIn = true;
          console.log('Login successful');
        } else {
          console.error('Login failed');
        }
      });
  }

  checkSession(): void {
    this.http.get<LoginResponse>(this.parenturl + '/auth/login.php', { withCredentials: true })
      .subscribe(response => {
        console.log(response);
        if (response.loggedIn) {
          this.loggedIn = true;
          console.log('User is already logged in');
        } else {
          console.log('User is not logged in');
        }
      });
  }

  fetchData(): void {
    this.http.get<DataResponse>(this.parenturl + '/testauth.php', { withCredentials: true })
      .subscribe(response => {
        if (response.success) {
          this.data = response.data;
          console.log('Data fetched successfully');
        } else {
          console.error('Failed to fetch data');
        }
      });
  }

  logout(): void {
    this.http.get<LoginResponse>(this.parenturl + '/auth/logout.php', { withCredentials: true })
      .subscribe(response => {
        if (!response.loggedIn) {
          this.loggedIn = false;
          this.data = null;
          console.log('Logout successful');
        } else {
          console.error('Logout failed');
        }
      });
  }
}
