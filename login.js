
/* file that handles all the login javascript functionality in our website. 
Author:- Neil Joseph */

document.addEventListener('DOMContentLoaded', () => {
    // Tab switching functionality
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        // Remove active class from all buttons
        tabBtns.forEach(b => b.classList.remove('active'));
        
        // Add active class to clicked button
        btn.classList.add('active');
        
        // Hide all tab contents
        tabContents.forEach(content => {
          content.style.display = 'none';
        });
        
        // Show the selected tab content
        const tabId = btn.getAttribute('data-tab');
        document.getElementById(`${tabId}-tab`).style.display = 'block';
      });
    });
    
    // Form submission handlers
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    
    loginForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const email = document.getElementById('loginEmail').value;
      const password = document.getElementById('loginPassword').value;
      
      console.log('Login attempt:', { email, password });
      
      // For demo purposes, redirect to profile
      localStorage.setItem('isLoggedIn', 'true');
      window.location.href = 'profile.html';
    });
    
    registerForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const fullName = document.getElementById('fullName').value;
      const userName = document.getElementById('userName').value;
      const email = document.getElementById('registerEmail').value;
      const password = document.getElementById('registerPassword').value;
      
      console.log('Register attempt:', { fullName, userName, email, password });
      
      // For demo purposes, redirect to profile
      localStorage.setItem('isLoggedIn', 'true');
      localStorage.setItem('userName', userName);
      window.location.href = 'profile.html';
    });
  });
  