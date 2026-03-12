<?php
\ = file_get_contents('app/Http/Controllers/AcademicoController.php');
\ = "->addColumn('instructor_nombre', function (\) {\r\n                  return \->instructor->full_name ?? 'Sin instructor';\r\n              })";
\ = "->addColumn('instructor_nombre', function (\) {\n                  return \->instructor->full_name ?? 'Sin instructor';\n              })";

\ = "->addColumn('instructor_nombre', function (\) use (\, \, \) {\n                  if (!in_array(\, \)) {\n                      \ = \App\Models\CursoAsignacion::with('docente')->where('curso_id', \->id)->where('estudiante_id', \->id)->activas()->first();\n                      if (\ && \->docente) {\n                          return trim(\->docente->name . ' ' . \->docente->apellido1);\n                      }\n                  }\n                  return \->instructor->full_name ?? 'Sin docente asignado';\n              })";

\ = str_replace(\, \, \);
\ = str_replace(\, \, \);
file_put_contents('app/Http/Controllers/AcademicoController.php', \);
echo "Modificado exitosamente";
