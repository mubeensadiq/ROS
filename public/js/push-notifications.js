var _registration = null;

console.log(window);
var vapid_public_key = window.vapid_public_key;

function registerServiceWorker() {
  if(navigator.serviceWorker !== undefined){
    return navigator.serviceWorker.register('/js/service-worker.js')
    .then(function(registration) {
      //console.log('Service worker successfully registered.');
      _registration = registration;
      return registration;
    })
    .catch(function(err) {
      document.getElementById('notification').style.display="none";
      //console.error('Unable to register service worker.', err);
    });
  }
  
}
function askPermission(url = '/enable-notifiactions') {
  return new Promise(function(resolve, reject) {
    const permissionResult = Notification.requestPermission(function(result) {
      resolve(result);
    });
    if (permissionResult) {
      permissionResult.then(resolve, reject);
    }
  })
  .then(function(permissionResult) {
    if (permissionResult !== 'granted') {
      throw new Error('We weren\'t granted permission.');
    }
    else{
      subscribeUserToPush(url);
    }
  });
}
function urlBase64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');
  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);
  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}
function getSWRegistration(){
  var promise = new Promise(function(resolve, reject) {
  // do a thing, possibly async, then…
  if (_registration != null) {
    resolve(_registration);
  }
  else {
    reject(Error("It broke"));
  }
  });
  return promise;
}
function subscribeUserToPush(url) {
  getSWRegistration()
  .then(function(registration) {
    const subscribeOptions = {
      userVisibleOnly: true,
      applicationServerKey: urlBase64ToUint8Array(
        vapid_public_key
      )
    };
    return registration.pushManager.subscribe(subscribeOptions);
  })
  .then(function(pushSubscription) {
   // console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
    sendSubscriptionToBackEnd(pushSubscription, url);
    return pushSubscription;
  });
}
function sendSubscriptionToBackEnd(subscription, url = '/api/v1/save-subscription/') {
  return fetch(url + auth_id, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(subscription)
  })
  .then(function(response) {
    if (!response.ok) {
      throw new Error('Bad status code from server.');
    }
    return response.json();
  })
  .then(function(responseData) {
    if (!(responseData.success)) {
      throw new Error('Bad response from server.');
    }
    else{
      window.location.reload();
    }
  });
}
function removeSubscriptionToBackEnd(subscription) {
  return fetch('/api/v1/delete-subscription/'+auth_id, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(subscription)
  })
  .then(function(response) {
    if (!response.ok) {
      throw new Error('Bad status code from server.');
    }
    return response.json();
  })
  .then(function(responseData) {
    if (!(responseData.success)) {
      throw new Error('Bad response from server.');
    }else{
     window.location.reload();
    }
  });
}
function enableNotifications(url){
  //register service worker
  //check permission for notification/ask
  askPermission(url);
  
}

function disableNotifications(){
    try{
        Print.postMessage('deleteToken');
    }
    catch(err){
        
    }
  getSWRegistration()
  .then(function(registration) {
    return registration.pushManager.getSubscription()
    .then(function(subscription) {
      if (subscription) {
        subscription.unsubscribe();
      }
      return subscription;
    })
  })
  .then(function(pushSubscription) {
    removeSubscriptionToBackEnd(pushSubscription);
    return pushSubscription;
  });
}

function returnEndpoint(){
  var promise = new Promise(function(resolve, reject) {
    _registration.pushManager.getSubscription()
    .then(function(subscription) {
      isSubscribed = !(subscription === null);
      if (isSubscribed) {
        resolve(subscription.endpoint);
      } else {
        resolve('');
      }
    });
  });
  return promise;
}
registerServiceWorker();