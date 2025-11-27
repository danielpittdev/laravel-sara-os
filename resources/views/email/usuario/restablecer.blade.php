<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" lang="en">

   <head>
      <link
         rel="preload"
         as="image"
         href="https://rezerva.es/media/logo/icon.png" />
      <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
      <meta name="x-apple-disable-message-reformatting" />
   </head>

   <body class="bg-light" style="margin:0">
      <!--$--><!--html--><!--head--><!--body-->
      <table
         border="0"
         width="100%"
         cellpadding="0"
         cellspacing="0"
         role="presentation"
         align="center">
         <tbody>
            <tr>
               <td
                  style='margin:auto;font-family:ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"'>
                  <table
                     align="center"
                     width="100%"
                     border="0"
                     cellpadding="0"
                     cellspacing="0"
                     role="presentation"
                     style="max-width:465px;margin-bottom:2.5rem;margin-right:auto;margin-left:auto;padding:1.25rem">
                     <tbody>
                        <tr style="width:100%">
                           <td>
                              <table
                                 align="center"
                                 width="100%"
                                 border="0"
                                 cellpadding="0"
                                 cellspacing="0"
                                 role="presentation"
                                 style="margin-top:2.5rem">
                                 <tbody>
                                    <tr>
                                       <td>
                                          <img
                                             alt="Logo Example"
                                             height="50"
                                             src="https://rezerva.es/media/logo/icon.png"
                                             style="display:block;outline:none;border:none;text-decoration:none;margin-bottom:0rem;margin-top:0rem"
                                             width="50" />
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                              <h1
                                 style="font-size:1.5rem;line-height:1.3333333333333333;color:rgb(0,0,0);font-weight:400;text-align:left;padding:0rem;margin-bottom:2rem;margin-top:2rem;margin-right:0rem;margin-left:0rem">
                                 Restablecimiento de la cuenta
                              </h1>
                              <p
                                 style="font-size:0.875rem;line-height:1.4285714285714286;text-align:start;color:rgb(0,0,0);margin-top:16px;margin-bottom:16px">
                                 Hola <strong>{{ $user->nombre }}</strong>,
                              </p>
                              <p
                                 style="font-size:0.875rem;line-height:1.625;text-align:start;color:rgb(0,0,0);margin-top:16px;margin-bottom:16px">
                                 Tu cuenta se ha establecido correctamente, la contraseña
                                 se ha podido cambiar correctamente. Desde el siguiente
                                 botón podrá de nuevo ir al
                                 <strong>inicio de sesión</strong>.
                              </p>
                              <p
                                 style="font-size:0.875rem;line-height:1.625;text-align:start;color:rgb(0,0,0);margin-top:16px;margin-bottom:16px">
                                 Si no has sido tú, por favor, póngase inmediatamente en
                                 contacto con nosotros.
                              </p>
                              <table
                                 align="center"
                                 width="100%"
                                 border="0"
                                 cellpadding="0"
                                 cellspacing="0"
                                 role="presentation"
                                 style="text-align:left;margin-top:32px;margin-bottom:32px">
                                 <tbody>
                                    <tr>
                                       <td>
                                          <a
                                             href="{{ $url }}"
                                             style="line-height:1.4285714285714286;text-decoration:none;display:inline-block;max-width:100%;mso-padding-alt:0px;padding-bottom:10px;padding-top:10px;padding-right:20px;padding-left:20px;background-color:rgb(97,95,255);border-radius:0.375rem;color:rgb(255,255,255);font-size:0.875rem;font-weight:600;text-decoration-line:none;text-align:left"
                                             target="_blank"><span></span><span
                                                style="max-width:100%;display:inline-block;line-height:120%;mso-padding-alt:0px;mso-text-raise:7.5px">Iniciar sesión</span><span></span></a>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                              <p
                                 style="font-size:0.875rem;line-height:1.4285714285714286;text-align:start;color:rgb(0,0,0);margin-top:16px;margin-bottom:16px">
                                 Un cordial saludo,<br />el equipo de
                                 <strong>{{ env('APP_NAME') }}</strong>
                              </p>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
      <!--/$-->
   </body>

</html>
