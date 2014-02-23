<?
 require_once "C:\wamp\bin\php\php5.4.3\PEAR\pear\Mail.php";
 
 public class Email {

                      function enviar( $de , $para , $assunto, $mensagem = "", $content_type = "plain")
                      {
                          //Configurações da autenticação do servidor SMTP
                          $servidor = "127.0.0.1";
                          $porta = "25";
                          $usuario = "usuario";
                          $senha = "senha";
                          $erros = "";
                          
                          //Valida o content_type do e-mail
                          if( $content_type == "html")
                              $content_type = "text/html; charset=utf-8";
                          else
                              $content_type = "text/plain; charset=utf-8";
                          //Configuração do cabeçalho da mensagem
                          $headers = array ('From' => "email@servidorsmtp.com.br",
                              'To' => $para
                              'Subject' => $assunto,
                              'Reply-To' => $de,
                              'Content-Type' => $content_type,
                              'MIME-Version' => "1.0",
                              'Content-Transfer-Encoding' => "base64".chunk_split(base64_encode($mensagem))
                          );
                          //Constroi o objeto para futuro envio
                          $smtp = Mail::factory('smtp',
                              array ('host' => $servidor,
                              'port' => $porta,
                              'auth' => true,
                              'username' => $usuario,
                              'password' => $senha)
                          );
                          //Efetua o envio atraves da classe
                          $mail = $smtp->send($para, $headers, $mensagem);
                          //Se ocorrerem errors, adicionamos na variavel de retorno
                          if (PEAR::isError($mail))
                              $erros = $mail->getMessage();
                          //Efetua o retorno
                          return $erros;
                      }
                  }
                  ?>
