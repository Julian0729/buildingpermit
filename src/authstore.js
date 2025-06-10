/**
 * src/stores/authStore.js
 *
 * A simple reactive store to simulate user authentication for demonstration purposes.
 * DO NOT use this for production applications as it stores data only in memory
 * and is not secure.
 */

import { reactive } from "vue";

// Reactive object to store registered users
// Each user is an object: { username: '...', password: '...' }
const registeredUsers = reactive([]);

/**
 * Registers a new user.
 * @param {string} username The username for the new account.
 * @param {string} password The password for the new account.
 * @returns {boolean} True if registration was successful, false if username already exists.
 */
function registerUser(username, password) {
  if (registeredUsers.some((user) => user.username === username)) {
    console.warn(`Registration failed: Username '${username}' already exists.`);
    return false; // Username already exists
  }
  registeredUsers.push({ username, password });
  console.log(`User '${username}' registered successfully.`);
  return true; // Registration successful
}

/**
 * Checks if the provided credentials match a registered user.
 * @param {string} username The username to check.
 * @param {string} password The password to check.
 * @returns {boolean} True if credentials are valid, false otherwise.
 */
function checkCredentials(username, password) {
  return registeredUsers.some(
    (user) => user.username === username && user.password === password
  );
}

/**
 * Checks if a username already exists.
 * @param {string} username The username to check.
 * @returns {boolean} True if the username exists, false otherwise.
 */
function userExists(username) {
  return registeredUsers.some((user) => user.username === username);
}

// Expose the functions and the registered users array (for inspection, not direct modification outside functions)
export {
  registeredUsers, // For debugging/inspection, not direct modification in components
  registerUser,
  checkCredentials,
  userExists,
};
