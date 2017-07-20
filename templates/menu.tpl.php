<div class='container'>
   <h2>dotstudioPRO React API Routes Options</h2>
   <form action='' method='POST' enctype='multipart/form-data'>
      <table class='form-table widefat'>
         <thead>
         </thead>
         <tbody>
            <tr>
               <td>
                  <span>API Namespace</span>
                  <span class='description'>The namespace for the API.  There is no need to change this unless we need to whitelist the API routes.</span>
               </td>
               <td>
                  <input type='text' name='dspapi-api-namespace' value='<?php echo get_option("dspapi-api-namespace") ?: "dsp" ?>' />
               </td>
            </tr>
            <tr>
               <td>
                  <span>Transient Cache Timeout</span>
                  <span class='description'>The amount of time that posts and various options stay in cache (in seconds).  Set this higher to speed up your site due to cached result returns, set it low if you change the site frequently.</span>
               </td>
               <td>
                  <input type='text' name='dspapi_transient_cache_timeout' value='<?php echo get_option("dspapi_transient_cache_timeout") ?: "300" ?>' />
               </td>
            </tr>
         </tbody>
         <tfoot>
            <tr>
               <td colspan='2'>
                  <button class='button button-primary'>Save</button>
               </td>
            </tr>
         </tfoot>
      </table>
      <input type='hidden' name='dspdev-save-react-api-routes-options' value='1' />
   </form>
</div>